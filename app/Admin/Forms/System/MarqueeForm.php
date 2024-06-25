<?php

namespace App\Admin\Forms\System;

use App\Models\Setting;
use Encore\Admin\Widgets\Form;
use Illuminate\Http\Request;

class MarqueeForm extends Form
{
    /**
     * The form title.
     *
     * @var string
     */
    public $title = '首页跑马灯';

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
        $this->select('wxapp_index_page_marquee_enable', '是否启用')->options([0 => '关闭', 1 => '开启']);
        $this->text('wxapp_index_page_marquee_text', '显示内容')
            ->rules('required_if:wxapp_index_page_marquee_enable,1', ['required_if' => '启用跑马灯时，此字段不能为空']);
        $this->text('wxapp_index_page_marquee_url', '小程序页面链接')
            ->rules('required_if:wxapp_index_page_marquee_enable,1', ['required_if' => '启用跑马灯时，此字段不能为空']);
    }

    /**
     * The data of the form.
     *
     * @return array $data
     */
    public function data()
    {
        return [
            'wxapp_index_page_marquee_enable'   =>  getSettingValueByKey('wxapp_index_page_marquee_enable', 0),
            'wxapp_index_page_marquee_text'     =>  getSettingValueByKey('wxapp_index_page_marquee_text', ''),
            'wxapp_index_page_marquee_url'      =>  getSettingValueByKey('wxapp_index_page_marquee_url', ''),
        ];
    }
}
