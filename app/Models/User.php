<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Illuminate\Database\Eloquent;
use Auth;

class User extends Authenticatable
{
    use EntrustUserTrait;

    /**
     *mass-assignment黑名单
     *
     *@var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     *给予用户角色
     *@param array $rolesId 用户角色id
     *@return void
     */
    public function giveRoleTo(array $rolesId){
        $this->detachRoles();
        $this->attachRolesToId($rolesId);
    }

    /**
     *给用户增加权限
     *
     *@param mixed $roles
     *@return void
     */
    public function attachRolesToId($rolesId)
    {
        foreach ($rolesId as $roleId) {
            $this->attachRole($roleId);
        }
    }

    /**
     *检测用户是否有权限访问某链接
     *
     * @param mixed $permission 路由字符串或数组
     * @param bool 
     * @return bool
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

            // If we've made it this far and $requireAll is FALSE, then NONE of the perms were found
            // If we've made it this far and $requireAll is TRUE, then ALL of the perms were found.
            // Return the value of $requireAll;
            return $requireAll;
        } else {
            foreach ($this->cachedRoles() as $role) {
                // Validate against the Permission table
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
