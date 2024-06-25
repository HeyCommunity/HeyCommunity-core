<?php

namespace App\Admin\Controllers;

use App\Models\Common\Thumb;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ThumbController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '点赞';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Thumb());
        $grid->model()->latest();

        $grid->column('id', 'Id');
        $grid->column('user.nickname', '点赞人');
        $grid->column('entity_text', '目标实体')->display(function () {
            return $this->getEntityTextForAdmin();
        });
        $grid->column('created_at', '时间');

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
        $show = new Show(Thumb::findOrFail($id));

        $show->field('id', 'Id');
        $show->field('user_id', 'User id');
        $show->field('entity_class', 'Entity class');
        $show->field('entity_id', 'Entity id');
        $show->field('type', 'Type');
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
        $form = new Form(new Thumb());

        $form->number('user_id', 'User id');
        $form->text('entity_class', 'Entity class');
        $form->number('entity_id', 'Entity id');
        $form->text('type', 'Type');

        return $form;
    }
}
