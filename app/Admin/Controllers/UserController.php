<?php

namespace App\Admin\Controllers;

use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Widgets\Table;

class UserController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '用户';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User());

        $grid->model()->latest();

        $grid->column('id', 'ID')->sortable();
        $grid->column('avatar', '头像')->image(null, 20, 20);
        $grid->column('nickname', '昵称');
        $grid->column('gender', '性别')->using(User::$genders);
        $grid->column('province_city', '省市')->display(function () {
            if ($this->wx_user_info) return $this->wx_user_info['province'] . $this->wx_user_info['city'];
        })->default('-');
        $grid->column('bio', '一句话简介')->hide();
        $grid->column('post_num', '动态数')->expand(function ($model) {
            $posts = $model->posts()->latest()->get()->map(function ($post) {
                return $post->only('id', 'content', 'created_at');
            });
            return new Table(['ID', '内容', '创建时间'], $posts->toArray());
        });
        $grid->column('thumb_up_num', '点赞数');
        $grid->column('comment_num', '评论数')->expand(function ($model) {
            $posts = $model->postComments()->latest()->get()->map(function ($post) {
                return $post->only('id', 'content', 'created_at');
            });

            return new Table(['ID', '内容', '创建时间'], $posts->toArray());
        });
        $grid->column('last_active_at', '最后活跃时间')->sortable();
        $grid->column('created_at', '注册时间')->sortable();

        $grid->disableCreateButton();

        $grid->actions(function ($actions) {
            $actions->disableDelete();
            $actions->disableEdit();
            $actions->disableView();
        });

        $grid->filter(function($filter){
            $filter->like('nickname', '昵称');

            $filter->scope('has_wx_user_info', '有微信资料')->whereNotNull('wx_user_info');
            $filter->scope('today_active', '今日活跃')->whereDate('last_active_at', date('Y-m-d'));

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
        $show = new Show(User::findOrFail($id));

        $show->field('id', 'Id');
        $show->field('wx_open_id', 'Wx open id');
        $show->field('wx_union_id', 'Wx union id');
        $show->field('nickname', 'Nickname');
        $show->field('realname', 'Realname');
        $show->field('gender', 'Gender');
        $show->field('bio', 'Bio');
        $show->field('avatar', 'Avatar');
        $show->field('cover', 'Cover');
        $show->field('phone', 'Phone');
        $show->field('email', 'Email');
        $show->field('password', 'Password');
        $show->field('is_admin', 'Is admin');
        $show->field('remember_token', 'Remember token');
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
        $form = new Form(new User());

        $form->text('wx_open_id', 'Wx open id');
        $form->text('wx_union_id', 'Wx union id');
        $form->text('nickname', 'Nickname');
        $form->text('realname', 'Realname');
        $form->text('gender', 'Gender');
        $form->text('bio', 'Bio');
        $form->image('avatar', 'Avatar')->default('images/users/default-avatar.jpg');
        $form->image('cover', 'Cover')->default('images/users/default-cover.jpg');
        $form->mobile('phone', 'Phone');
        $form->email('email', 'Email');
        $form->password('password', 'Password');
        $form->switch('is_admin', 'Is admin');
        $form->text('remember_token', 'Remember token');

        return $form;
    }
}
