<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/27 0027
 * Time: 16:22
 */

namespace app\admin\validate;


use think\Validate;

class Service extends Validate
{
    protected $rule = [
        ['username', 'require', '名字不能为空'],
        ['title', 'require', '标题不能为空'],
        ['content', 'require', '内容不能为空'],
        ['title', 'require', '问题不能为空'],
        ['start_time', 'require', '起始时间不能为空'],
        ['end_time', 'require', '结束时间不能为空'],
        // ['tel', '/^1[3|4|5|8][0-9]\d{8}$/require', '电话号码不合法|电话必须填'],


    ];

}