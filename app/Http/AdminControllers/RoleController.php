<?php

namespace App\Http\AdminControllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\RoleCreateRequest;
use App\Http\Requests\RoleUpdateRequest;
use App\Http\AdminControllers\Controller;
use App\Models\Permission;
use App\Models\Role;

class RoleController extends Controller
{
    protected $fields = [
        'name' => '',
        'display_name' => '',
        'description' => '',
        'perms' => [],
    ];


    /**
     *角色列表页
     *
     *@param obj $request 请求对象
     *@return ajax
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = array();
            $data['draw'] = $request->get('draw');
            $start = $request->get('start');
            $length = $request->get('length');
            $order = $request->get('order');
            $columns = $request->get('columns');
            $search = $request->get('search');
            $data['recordsTotal'] = Role::count();
            if (strlen($search['value']) > 0) {
                $data['recordsFiltered'] = Role::where(function ($query) use ($search) {
                    $query->where('name', 'LIKE', '%' . $search['value'] . '%')
                        ->orWhere('description', 'like', '%' . $search['value'] . '%');
                })->count();
                $data['data'] = Role::where(function ($query) use ($search) {
                    $query->where('name', 'LIKE', '%' . $search['value'] . '%')
                        ->orWhere('description', 'like', '%' . $search['value'] . '%');
                })
                    ->skip($start)->take($length)
                    ->orderBy($columns[$order[0]['column']]['data'], $order[0]['dir'])
                    ->get();
            } else {
                $data['recordsFiltered'] = Role::count();
                $data['data'] = Role::
                skip($start)->take($length)
                    ->orderBy($columns[$order[0]['column']]['data'], $order[0]['dir'])
                    ->get();
            }
            return response()->json($data);
        }
        return view('admin.role.index');
    }

    /**
     *新建角色页
     *
     *@return viod
     */
    public function create()
    {
        $data = [];
        $data['permissionAll']=[];
        foreach ($this->fields as $field => $default) {
            $data[$field] = old($field, $default);
        }
        $arr = Permission::all()->toArray();

        foreach ($arr as $v) {
            $data['permissionAll'][$v['cid']][] = $v;
        }
        return view('admin.role.create', $data);
    }

    /**
     *保存新建角色
     *
     *@param obj $request 请求数据
     *@return void
     */
    public function store(Request $request)
    {
        $role = new Role();
       foreach (array_keys($this->fields) as $field) {
            $role->$field = $request->get($field);
        }
        unset($role->perms);
        $role->save();
        if (is_array($request->get('permissions'))) {
            $role->givePermissionsTo($request->get('permissions'));
        }
        return redirect('/admin/role')->withSuccess('添加成功！');
    }

    /**
     *更新角色页
     *
     *@param int $id 角色id
     *@return void
     */
    public function edit($id)
    {

        $role = Role::find((int)$id);
        if (!$role) return redirect('/admin/role')->withErrors("找不到该角色!");
        $permissions = [];
        if ($role->perms) {
            foreach ($role->perms as $v) {
                $permissions[] = $v->id;
            }
        }
        $role->perms = $permissions;
        foreach (array_keys($this->fields) as $field) {
            $data[$field] = old($field, $role->$field);
        }
        $arr = Permission::all()->toArray();
        foreach ($arr as $v) {
            $data['permissionAll'][$v['cid']][] = $v;
        }
        $data['id'] = (int)$id;
        return view('admin.role.edit', $data);
    }

    /**
     *保存更新角色
     *
     *@param obj $request 请求信息（表单）
     *@param int $id 角色id
     *@return viod
     */
    public function update(RoleUpdateRequest $request, $id)
    {
        $role = Role::find((int)$id);
        foreach (array_keys($this->fields) as $field) {
            $role->$field = $request->get($field);
        }
        unset($role->perms);
        $role->save();
        $role->givePermissionsTo($request->get('permissions',[]));
        return redirect('/admin/role')->withSuccess('修改成功！');
    }

    /**
     *删除角色
     *
     *@param int $id 角色id
     *@return viod
     */
    public function destroy($id)
    {
        $role = Role::find((int)$id);
        if ($role) {
            $role->delete();
        } else {
            return redirect()->back()
                ->withErrors("删除失败");
        }
        return redirect()->back()
            ->withSuccess("删除成功");
    }
}
