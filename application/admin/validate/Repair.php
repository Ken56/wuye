<?php
/**
 * Created by PhpStorm.
 * User: zy350
 * Date: 2018/5/13
 * Time: 16:20
 */

namespace app\admin\validate;


use think\Validate;

class Repair extends Validate
{

    protected $rule = [
        ['title', 'require', '标题不能为空'],
        ['name', 'require', '报修人不能为空'],
        ['tel', 'require', '电话号码不能为空'],
        ['address', 'require', '地址不能为空'],
        ['content', 'require', '内容不能为空'],
    ];
    protected $updateTime = false;

}