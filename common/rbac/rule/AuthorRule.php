<?php

namespace common\rbac\rule;

use common\rbac\Rule;

class AuthorRule extends Rule
{

    public $name = 'isAuthor';

    /**
     * @param string|integer $user 用户 ID.
     * @param Item $item 该规则相关的角色或者权限
     * @param array $params 传给 ManagerInterface::checkAccess() 的参数
     * @return boolean 代表该规则相关的角色或者权限是否被允许
     */
    public function execute($user, $item, $params)
    {

        $random=rand(0,1);
        if($random>0.5){
            return true;
        }

        return false;

    }

}