@extends('dashboard.layouts.default')

@section('mainContent')
<div class="main-content">
  <div class="header">
    <div class="container-fluid">
      <div class="header-body">
        <div class="row align-items-end">
          <div class="col">
            <h6 class="header-pretitle">Comments</h6>
            <h1 class="header-title">评论</h1>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="table-responsive mb-0">
            <table class="table table-sm table-nowrap card-table">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>用户</th>
                  <th>目标用户</th>
                  <th>目标实体</th>
                  <th style="max-width:370px;">内容</th>
                  <th>点赞/评论</th>
                  <th>发布时间</th>
                  <th>操作</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($comments as $comment)
                  <tr>
                    <td>{{ $comment->id }}</td>
                    <td>
                      <a href="{{ route('dashboard.users.show', $comment->user) }}" class="avatar avatar-xs d-inline-block me-2">
                        <img src="{{ asset($comment->user->avatar) }}" alt="{{ $comment->user->app_id }}" class="avatar-img rounded-circle">
                      </a>
                      <a href="{{ route('dashboard.users.show', $comment->user) }}">{{ $comment->user->nickname ?: 'NULL' }}</a>
                    </td>

                    <!-- 目标用户 -->
                    @if ($comment->parent)
                      <td>
                        <a href="{{ route('dashboard.users.show', $comment->parent->user) }}" class="avatar avatar-xs d-inline-block me-2">
                          <img src="{{ asset($comment->parent->user->avatar) }}" alt="{{ $comment->parent->user->app_id }}" class="avatar-img rounded-circle">
                        </a>
                        <a href="{{ route('dashboard.users.show', $comment->parent->user) }}">{{ $comment->parent->user->nickname ?: 'NULL' }}</a>
                      </td>
                    @else
                      <td>
                        <a href="{{ route('dashboard.users.show', $comment->commentable->user) }}" class="avatar avatar-xs d-inline-block me-2">
                          <img src="{{ asset($comment->commentable->user->avatar) }}" alt="{{ $comment->commentable->user->app_id }}" class="avatar-img rounded-circle">
                        </a>
                        <a href="{{ route('dashboard.users.show', $comment->commentable->user) }}">{{ $comment->commentable->user->nickname ?: 'NULL' }}</span>
                      </td>
                    @endif

                    <!-- 目标实体 -->
                    <td>
                      @if ($comment->entity_class === \Modules\Post\Entities\Post::class)
                        <a class="d-block" href="{{ route('dashboard.posts.show', $comment->entity_id) }}">{{ $comment->entity_name }}(ID:{{ $comment->entity_id }})</a>
                      @else
                        <span class="d-block">{{ $comment->entity_name }}(ID:{{ $comment->entity_id }})</span>
                      @endif

                      @if ($comment->parent)
                        @if ($comment->parent->entity_class === \Modules\Post\Entities\Post::class)
                          <a class="d-block mt-1" href="{{ route('dashboard.posts.show', $comment->parent->entity_id) }}">评论(ID:{{ $comment->parent->id }})</a>
                        @else
                          <span class="d-block mt-1">评论(ID:{{ $comment->parent->id }})</span>
                        @endif
                      @endif
                    </td>

                    <!-- 内容 -->
                    <td class="text-wrap">
                      @if (Str::length($comment->content) > 100)
                        <span data-bs-toggle="tooltip" title="{{ $comment->content }}">{{ Str::limit($comment->content, 100 * 2) }}</span>
                      @else
                        <span>{{ $comment->content }}</span>
                      @endif
                    </td>

                    <td>{{ $comment->thumb_up_num }} / {{ $comment->comment_num }}</td>
                    <td><span data-bs-toggle="tooltip" title="{{ $comment->created_at->diffForHumans() }}">{{ $comment->created_at }}</span></td>
                    <td>/</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>

        <div class="mb-5">
          {{ $comments->links() }}
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
