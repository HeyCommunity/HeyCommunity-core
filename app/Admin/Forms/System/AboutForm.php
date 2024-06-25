<?php

namespace App\Admin\Forms\System;

use Encore\Admin\Widgets\Form;
use Illuminate\Http\Request;

class AboutForm extends Form
{
    /**
     * The form title.
     *
     * @var string
     */
    public $title = '关于社区';

    /**
     * Handle the form request.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request)
    {
        foreach ($request->all() as $key => $value) {
            updateSettingColumn($key, $value);
        }
        
        admin_success('操作成功');

        return back();
    }

    /**
     * Build a form here.
     */
    public function form()
    {
        $this->text('wxapp_about_title', '标题')->rules('required|string');
        $this->text('wxapp_about_subtitle', '子标题')->rules('required|string');
        $this->simditor('wxapp_about_content', '内容')->rules('required|string');
    }

    /**
     * The data of the form.
     *
     * @return array $data
     */
    public function data()
    {
        return [
            'wxapp_about_title'     =>  getSettingValueByKey('wxapp_about_title', 'HEY社区'),
            'wxapp_about_subtitle'  =>  getSettingValueByKey('wxapp_about_subtitle', 'HeyCommunity'),
            'wxapp_about_content'   =>  getSettingValueByKey('wxapp_about_content', '欢迎使用HEY社区'),
        ];
    }
}
