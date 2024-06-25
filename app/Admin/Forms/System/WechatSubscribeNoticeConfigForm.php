<?php

namespace App\Admin\Forms\System;

use Encore\Admin\Widgets\Form;
use Illuminate\Http\Request;

class WechatSubscribeNoticeConfigForm extends Form
{
    /**
     * The form title.
     *
     * @var string
     */
    public $title = '微信订阅消息';

    /**
     * Handle the form request.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request)
    {
        $this->validate($request, [
            'wxapp_subscribe_message_enable'                =>  'required|boolean',
            'wxapp_subscribe_message_thumb_up_temp_id'      =>  'nullable|string',
            'wxapp_subscribe_message_comment_temp_id'       =>  'nullable|string',
            'wxapp_subscribe_message_reply_temp_id'         =>  'nullable|string',
        ]);

        systemUpdateEnvironmentValue([
            'WXAPP_SUBSCRIBE_MESSAGE_ENABLE'  =>  $request->get('wxapp_subscribe_message_enable') ? 'true' : 'false',
            'WXAPP_SUBSCRIBE_MESSAGE_THUMB_UP_TEMP_ID'  =>  $request->get('wxapp_subscribe_message_thumb_up_temp_id'),
            'WXAPP_SUBSCRIBE_MESSAGE_COMMENT_TEMP_ID'  =>  $request->get('wxapp_subscribe_message_comment_temp_id'),
            'WXAPP_SUBSCRIBE_MESSAGE_REPLY_TEMP_ID'  =>  $request->get('wxapp_subscribe_message_reply_temp_id'),
        ]);

        admin_success('操作成功');

        return back();
    }

    /**
     * Build a form here.
     */
    public function form()
    {
        $this->select('wxapp_subscribe_message_enable', '微信订阅消息')
            ->options([0 => '关闭', 1 => '开启'])->default(0)
            ->help("如开启，系统中的点赞、评论、回复等通知，将通过微信小程序一次性订阅消息发送给用户。<br>开启后请配置下方模板 ID");       // TODO: 补充模板说明
        $this->text('wxapp_subscribe_message_thumb_up_temp_id', '点赞消息模板 ID');
        $this->text('wxapp_subscribe_message_comment_temp_id', '评论消息模板 ID');
        $this->text('wxapp_subscribe_message_reply_temp_id', '回复消息模板 ID');
    }

    /**
     * The data of the form.
     *
     * @return array $data
     */
    public function data()
    {
        return [
            'wxapp_subscribe_message_enable'                =>  config('system.wxapp.subscribe_message.enable'),
            'wxapp_subscribe_message_thumb_up_temp_id'      =>  config('system.wxapp.subscribe_message.thumb_up_temp_id'),
            'wxapp_subscribe_message_comment_temp_id'       =>  config('system.wxapp.subscribe_message.comment_temp_id'),
            'wxapp_subscribe_message_reply_temp_id'         =>  config('system.wxapp.subscribe_message.reply_temp_id'),
        ];
    }
}
