<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/26 0026
 * Time: 11:44
 */

namespace app\home\validate;


use think\Validate;

class Renzheng extends Validate
{
    protected $rule = [
        ['name', 'require', '姓名不能为空'],
        ['url', 'require', '房号不能为空'],
        ['tel', 'require|number|length:11', '电话必须填|电话必须是数字|电话长度11位'],
        ['rank', 'require|number|length:18','身份证号码必须填|必须是数字|身份证长度18位,您的输入不正确'],
       // ['tel', '/^1[3|4|5|8][0-9]\d{8}$/require', '电话号码不合法|电话必须填'],


    ];

}