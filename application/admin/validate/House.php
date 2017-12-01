<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/30 0030
 * Time: 16:54
 */

namespace app\admin\validate;


use think\Validate;

class House extends Validate
{
    protected $rule = [
        ['username', 'require', '名字不能为空'],
        ['title', 'require', '标题不能为空'],
        ['content', 'require', '内容不能为空'],
        ['start_time', 'require', '起始时间不能为空'],
        ['end_time', 'require', '结束时间不能为空'],
        ['is_deal', 'require', '类型必须选'],
        ['price', 'require|number', '价格不能为空|价格必须是数字'],
        ['unit', 'require', '价格单位必须选'],
        ['image', 'safe', '图片没上传'],
        ['tel', 'require|number|length:11', '电话必须填|电话必须是数字|电话长度11位'],


    ];

}