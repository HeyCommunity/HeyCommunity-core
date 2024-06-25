<?php

namespace App\Admin\Controllers;

use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Modules\Activity\Entities\Activity;

class ActivityController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '活动管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Activity());

        $grid->column('id', 'ID');
        $grid->column('user.nickname', '用户');
        $grid->column('cover', '活动封面')->image(null, 60, 60);
        $grid->column('title', '活动标题');
        $grid->column('price', '价格');
        $grid->column('total_ticket_num', '总票数');
        $grid->column('surplus_ticket_num', '余票数');
        $grid->column('status', '状态')->using(Activity::$statuses);
        $grid->column('created_at', '创建时间');

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
        $show = new Show(Activity::findOrFail($id));

        $show->field('id', 'Id');
        $show->field('user_id', 'User id');
        $show->field('title', 'Title');
        $show->field('cover', 'Cover');
        $show->field('intro', 'Intro');
        $show->field('content', 'Content');
        $show->field('address_name', 'Address name');
        $show->field('address_full', 'Address full');
        $show->field('latitude', 'Latitude');
        $show->field('longitude', 'Longitude');
        $show->field('started_at', 'Started at');
        $show->field('ended_at', 'Ended at');
        $show->field('price', 'Price');
        $show->field('total_ticket_num', 'Total ticket num');
        $show->field('surplus_ticket_num', 'Surplus ticket num');
        $show->field('read_num', 'Read num');
        $show->field('favorite_num', 'Favorite num');
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
        $form = new Form(new Activity());

        $form->number('user_id', 'User id');
        $form->text('title', 'Title');
        $form->image('cover', 'Cover');
        $form->text('intro', 'Intro');
        $form->textarea('content', 'Content');
        $form->text('address_name', 'Address name');
        $form->text('address_full', 'Address full');
        $form->text('latitude', 'Latitude');
        $form->text('longitude', 'Longitude');
        $form->datetime('started_at', 'Started at')->default(date('Y-m-d H:i:s'));
        $form->datetime('ended_at', 'Ended at')->default(date('Y-m-d H:i:s'));
        $form->decimal('price', 'Price');
        $form->number('total_ticket_num', 'Total ticket num');
        $form->number('surplus_ticket_num', 'Surplus ticket num');
        $form->number('read_num', 'Read num');
        $form->number('favorite_num', 'Favorite num');
        $form->number('thumb_up_num', 'Thumb up num');
        $form->number('thumb_down_num', 'Thumb down num');
        $form->number('comment_num', 'Comment num');
        $form->switch('status', 'Status');

        return $form;
    }
}
