<?php

namespace App\Admin\Controllers;

use App\Models\Notice;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class NoticeController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '通知';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Notice());

        $grid->model()->latest();

        $grid->column('id', 'ID');
        $grid->column('user.nickname', '接收者');
        $grid->column('sender.nickname', '发送者');
        $grid->column('type', '类型')->using(Notice::$types);
        $grid->column('entity_text', '实体')->display(function () {
            return $this->getEntityTextForAdmin();
        });

        $grid->column('read_at', '阅读时间')->default('-');

        $grid->column('created_at', '创建时间');

        $grid->disableCreateButton();

        $grid->actions(function ($actions) {
            $actions->disableEdit();
            $actions->disableView();
        });

        return $grid;
    }
}
