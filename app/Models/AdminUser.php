<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Illuminate\Database\Eloquent;
use Auth;

class AdminUser extends Authenticatable
{
    use EntrustUserTrait;

    /**
     *mass-assignment白名单
     *
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     *隐藏的数组或json数组变量
     *
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     *给予用户角色
     *
     *@param array $rolesId 角色id数组
     *@return void
     */
    public function giveRoleTo(array $rolesId){
        $this->detachRoles();
        $this->attachRolesToId($rolesId);
    }

    /**
     *给用户添加角色
     *
     *@param array $rolesId 角色id数组
     *@return void
     */
    public function attachRolesToId($rolesId)
    {
        foreach ($rolesId as $roleId) {
            $this->attachRole($roleId);
        }
    }

    /**
     *判断用户是否有权限访问某个路由
     *
     *@param void $permission 路由
     *@param bool $requireAll 
     *@return bool
     */
    public function can($permission, $requireAll = false)
    {

        if(Auth::guard('web')->user()->id===1){
            return true;
        }
        if (is_array($permission)) {
            foreach ($permission as $permName) {
                $hasPerm = $this->can($permName);
                if ($hasPerm && !$requireAll) {
                    return true;
                } elseif (!$hasPerm && $requireAll) {
                    return false;
                }
            }
            return $requireAll;
        } else {
            foreach ($this->cachedRoles() as $role) {
                foreach ($role->cachedPermissions() as $perm) {
                    if (str_is( $permission, $perm->name) ) {
                        return true;
                    }
                }
            }
        }
        return false;
    }

}
