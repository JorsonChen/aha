<?php namespace App\Models;

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
    /**
     *给予角色权限
     *
     *@param array $permissionId 权限id数组
     *@return void
     */
    public function givePermissionsTo(array $permissionsId){
        $this->detachPermissions($this->perms);
        $this->attachPermissionToId($permissionsId);
    }

    /**
     *给角色添加权限
     *
     *@param array $permissionId 权限id数组
     *@return void
     */
    public function attachPermissionToId($permissionsId)
    {
        foreach ($permissionsId as $pid) {
            $this->attachPermission($pid);
        }
    }
}
