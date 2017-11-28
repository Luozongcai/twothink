<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/26 0026
 * Time: 11:44
 */

namespace app\admin\validate;


use think\Validate;

class Repairs extends Validate
{
    protected $rule = [
        ['username', 'require', '姓名不能为空'],
        ['url', 'require', '地址不能为空'],
        ['tel', 'require|number|length:11', '电话必须填|电话必须是数字|电话长度11位'],
        ['title', 'require', '问题不能为空'],
        ['content', 'require','问题描述不能为空'],
       // ['tel', '/^1[3|4|5|8][0-9]\d{8}$/require', '电话号码不合法|电话必须填'],


    ];

}