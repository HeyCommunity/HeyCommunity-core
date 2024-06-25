<?php

namespace App\Admin\Controllers;

use App\Models\Common\Comment;
use App\Models\Post\Post;
use App\Models\UserReport;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class UserReportController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '用户报告';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new UserReport());
        $grid->model()->latest();

        $grid->column('id', 'ID');
        $grid->column('reporter_user_nickname', '报告人')->display(function () {
            return $this->user ? $this->user->nickname : '';
        });
        $grid->column('creator_user_nickname', '发布人')->display(function () {
            return $this->entity->user->nickname;
        });
        $grid->column('entity_text', '目标实体')->display(function () {
            return $this->getEntityTextForAdmin();
        });
        $grid->column('entity_content', '内容')->display(function () {
            return $this->entity_content;
        });
        $grid->column('created_at', '报告时间');

        $grid->disableCreateButton();
        $grid->actions(function ($actions) {
            $actions->disableDelete();
            $actions->disableEdit();
            $actions->disableView();
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
        $show = new Show(UserReport::findOrFail($id));

        $show->field('id', 'Id');
        $show->field('user_id', 'User id');
        $show->field('entity_class', 'Entity class');
        $show->field('entity_id', 'Entity id');
        $show->field('type_id', 'Type id');
        $show->field('content', 'Content');
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
        $form = new Form(new UserReport());

        $form->number('user_id', 'User id');
        $form->text('entity_class', 'Entity class');
        $form->number('entity_id', 'Entity id');
        $form->switch('type_id', 'Type id');
        $form->text('content', 'Content');
        $form->switch('status', 'Status');

        return $form;
    }
}
