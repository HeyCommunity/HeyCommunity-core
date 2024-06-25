<?php

namespace App\Admin\Forms\System;

use Encore\Admin\Widgets\Form;
use Illuminate\Http\Request;

class RegulationForm extends Form
{
    /**
     * The form title.
     *
     * @var string
     */
    public $title = '社区准则';

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
        $this->text('wxapp_regulation_title', '标题')->rules('required|string');
        $this->simditor('wxapp_regulation_content', '内容')->rules('required|string');
    }

    /**
     * The data of the form.
     *
     * @return array $data
     */
    public function data()
    {
        return [
            'wxapp_regulation_title'     =>  getSettingValueByKey('wxapp_regulation_title', '社区准则'),
            'wxapp_regulation_content'   =>  getSettingValueByKey('wxapp_regulation_content', ''),
        ];
    }
}
