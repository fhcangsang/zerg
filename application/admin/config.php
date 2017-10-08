<?php
/**
 * Created by PhpStorm.
 * User: Jone
 * Date: 2017/10/8 0008
 * Time: 13:12
 */
return [
    // 默认输出类型
    'default_return_type' => 'html',
    // 视图输出字符串内容替换
    'view_replace_str' => [
        '__ADMIN_CSS__' => '/admin/public/css',
        '__ADMIN_JS__' => '/admin/public/js',
        '__ADMIN_IMAGES__' => '/admin/public/images',
        '__ADMIN_ACEADMIN__' => '/admin/aceadmin',
    ],
    'auth' => [  //有表前缀则带上表前缀
        /*'auth_on' => true,                      // 认证开关
        'auth_type' => 1,                         // 认证方式，1为实时认证；2为登录认证。
        'auth_group' => 'auth_group',        // 用户组数据表名
        'auth_group_access' => 'auth_group_access', // 用户-用户组关系表
        'auth_rule' => 'auth_rule',         // 权限规则表*/
        'auth_user' => 'admin_users'             // 用户信息表
    ],
];