<?php

namespace App\Http\Controllers\Api\Common;

use App\Events\Notices\MakeNoticeEvent;
use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Models\Common\Comment;
use App\Models\Post\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CommentController extends Controller
{
    /**
     * Handler
     */
    public function handler($entity, $content, $noticeType, $parentComment = null)
    {
        $user = Auth::guard('sanctum')->user();

        $commentStatus = 0;
        if (! config('system.ugc_audit', true)) $commentStatus = 1;
        if ($user->is_admin || $user->ugc_safety_level) $commentStatus = 1;

        $rootId = null;
        $parentId = null;
        $floorNumber = $entity->comments()->withTrashed()->count() + 1;

        if ($parentComment) {
            $parentId = $parentComment->id;
            $rootId = $parentComment->root_id ?: $parentComment->id;
        }

        $comment = Comment::create([
            'user_id'       =>  $user->id,
            'entity_type'   =>  get_class($entity),
            'entity_id'     =>  $entity->id,
            'content'       =>  $content,
            'root_id'       =>  $rootId,
            'parent_id'     =>  $parentId,
            'floor_number'  =>  $floorNumber,
            'status'        =>  $commentStatus,
        ]);

        $entity->increment('comment_num');
        if ($parentComment) $parentComment->increment('comment_num');

        // 创建 Notice
        if (($parentComment && $parentComment->user_id != $user->id)
            || (!$parentComment && $entity->user_id != $user->id)
        ) {
            event(new MakeNoticeEvent(
                $noticeType,
                $parentComment ? $parentComment->user : $entity->user,
                $user,
                $comment
            ));
        }


        $comment->refresh();
        return new CommentResource($comment);
    }

    /**
     * PostCommentHandler
     */
    public function postCommentHandler(Request $request)
    {
        $this->validate($request, [
            'post_id'       =>  'required_without:comment_id|integer',
            'comment_id'    =>  'required_without:post_id|integer',
            'content'       =>  'required|string',
        ]);

        if ($request->get('comment_id')) {
            $noticeType = 'post_comment_reply';
            $comment = Comment::findOrFail($request->get('comment_id'));
            $post = $comment->entity;
        } else {
            $noticeType = 'post_comment';
            $comment = null;
            $post = Post::findOrFail($request->get('post_id'));
        }

        return $this->handler($post, $request->get('content'), $noticeType, $comment);
    }

    /**
     * PostComment destroy handler
     */
    public function postCommentDestroyHandler(Request $request)
    {
        $request->validate([
            'id'    =>  'required|integer',
        ]);

        $user = $request->user();
        $comment = Comment::findOrFail($request->get('id'));

        //  判断是作者或管理员
        if ($comment->user_id === $user->id || $user->is_admin) {
            $entity = $comment->entity;
            $parent = $comment->parent;

            if ($comment->delete()) {
                if ($entity) $entity->decrement('comment_num');
                if ($parent) $parent->decrement('comment_num');

                return response()->json(['message' => '操作成功'], 202);
            }
        } else {
            return response()->json(['message' => '无权执行此操作'], 403);
        }
    }
}
