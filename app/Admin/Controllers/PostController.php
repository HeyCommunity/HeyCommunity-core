<?php

namespace App\Admin\Controllers;

use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Widgets\Table;
use Illuminate\Support\Str;
use Modules\Post\Entities\Post;

class PostController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '动态';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Post());

        $grid->model()->latest();

        $grid->column('id', 'ID')->sortable();
        $grid->column('status', '状态')->select(Post::$statuses);
        $grid->column('user.nickname', '作者');
        $grid->column('content', '内容')->display(function ($value) {
            return Str::limit($value, 20 * 2);
        });
        $grid->column('comment_num', '评论数')->expand(function ($model) {
            $comments = $model->comments()->take(10)->latest()->get()->map(function ($comment) {
                $data = $comment->only('id', 'content', 'created_at');
                array_splice($data, 1, 0, ['user' => $comment->user->nickname]);
                return $data;
            });

            return new Table(['ID', '作者', '内容', '发布时间'], $comments->toArray());
        });
        $grid->column('thumb_up_num', '点赞数');
        $grid->column('created_at', '发布时间');

        $grid->disableCreateButton();

        $grid->actions(function ($actions) {
            $actions->disableEdit();
            $actions->disableView();
        });

        $grid->filter(function($filter){
            $filter->equal('status', '状态')->select(Post::$statuses);
            $filter->like('user.nickname', '作者');
            $filter->like('content', '内容');
        });

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Post::findOrFail($id));

        $show->field('id', 'Id');
        $show->field('user_id', 'User id');
        $show->field('content', 'Content');
        $show->field('read_num', 'Read num');
        $show->field('favorite_num', 'Favorite num');
        $show->field('comment_num', 'Comment num');
        $show->field('thumb_up_num', 'Thumb up num');
        $show->field('thumb_down_num', 'Thumb down num');
        $show->field('status', 'Status');
        $show->field('created_at', 'Created at');
        $show->field('updated_at', 'Updated at');
        $show->field('deleted_at', 'Deleted at');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Post());

        $form->number('user_id', 'User id');
        $form->textarea('content', 'Content');
        $form->number('read_num', 'Read num');
        $form->number('favorite_num', 'Favorite num');
        $form->number('comment_num', 'Comment num');
        $form->number('thumb_up_num', 'Thumb up num');
        $form->number('thumb_down_num', 'Thumb down num');
        $form->switch('status', 'Status');

        return $form;
    }
}
