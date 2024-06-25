<?php

namespace App\Admin\Controllers;

use App\Models\Common\Comment;
use App\Models\Post\Post;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class CommentController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '评论';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Comment());

        $grid->model()->latest();

        $grid->column('id', 'ID');
        $grid->column('status', '状态')->select(Comment::$statuses);
        $grid->column('user.nickname', '发布者');
        $grid->column('content', '内容');
        $grid->column('entity_text', '目标实体')->display(function () {
            return $this->getEntityTextForAdmin();
        });

        $grid->column('thumb_up_num', '点赞数');
        $grid->column('comment_num', '评论数');

        $grid->column('created_at', '创建时间');

        $grid->disableCreateButton();

        $grid->actions(function ($actions) {
            $actions->disableEdit();
            $actions->disableView();
        });

        $grid->filter(function($filter){
            $filter->equal('status', '状态')->select(Comment::$statuses);
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
        $show = new Show(Comment::findOrFail($id));

        $show->field('id', 'Id');
        $show->field('root_id', 'Root id');
        $show->field('parent_id', 'Parent id');
        $show->field('floor_number', 'Floor number');
        $show->field('user_id', 'User id');
        $show->field('entity_class', 'Entity type');
        $show->field('entity_id', 'Entity id');
        $show->field('content', 'Content');
        $show->field('thumb_up_num', 'Thumb up num');
        $show->field('thumb_down_num', 'Thumb down num');
        $show->field('comment_num', 'Comment num');
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
        $form = new Form(new Comment());

        $form->number('root_id', 'Root id');
        $form->number('parent_id', 'Parent id');
        $form->number('floor_number', 'Floor number');
        $form->number('user_id', 'User id');
        $form->text('entity_class', 'Entity type');
        $form->number('entity_id', 'Entity id');
        $form->textarea('content', 'Content');
        $form->number('thumb_up_num', 'Thumb up num');
        $form->number('thumb_down_num', 'Thumb down num');
        $form->number('comment_num', 'Comment num');
        $form->switch('status', 'Status');

        return $form;
    }
}
