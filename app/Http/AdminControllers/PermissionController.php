<?php

namespace App\Http\AdminControllers;

use App\Events\permChangeEvent;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\PermissionCreateRequest;
use App\Http\Requests\PermissionUpdateRequest;
use Cache,Event;
use App\Http\AdminControllers\Controller;
use App\Models\Permission;

class PermissionController extends Controller
{
    
    protected $fields = [
        'name' => '',
        'display_name' => '',
        'description' => '',
        'cid' => 0,
        'icon'=>'',
    ];


    /**
     *权限列表页
     *
     *@param obj $request 请求对象
     *@param int $cid 权限层级id
     *@return ajax
     */
    public function index(Request $request, $cid = 0)
    {
        $cid = (int)$cid;
        if ($request->ajax()) {
            $data = array();
            $data['draw'] = $request->get('draw');
            $start = $request->get('start');
            $length = $request->get('length');
            $order = $request->get('order');
            $columns = $request->get('columns');
            $search = $request->get('search');
            $cid = $request->get('cid', 0);
            $data['recordsTotal'] = Permission::where('cid', $cid)->count();
            if (strlen($search['value']) > 0) {
                $data['recordsFiltered'] = Permission::where('cid', $cid)->where(function ($query) use ($search) {
                    $query
                        ->where('name', 'LIKE', '%' . $search['value'] . '%')
                        ->orWhere('description', 'like', '%' . $search['value'] . '%');
                })->count();
                $data['data'] = Permission::where('cid', $cid)->where(function ($query) use ($search) {
                    $query->where('name', 'LIKE', '%' . $search['value'] . '%')
                        ->orWhere('description', 'like', '%' . $search['value'] . '%');
                })
                    ->skip($start)->take($length)
                    ->orderBy($columns[$order[0]['column']]['data'], $order[0]['dir'])
                    ->get();
            } else {
                $data['recordsFiltered'] = Permission::where('cid', $cid)->count();
                $data['data'] = Permission::where('cid', $cid)->
                skip($start)->take($length)
                    ->orderBy($columns[$order[0]['column']]['data'], $order[0]['dir'])
                    ->get();
            }
            return response()->json($data);
        }
        $datas['cid'] = $cid;
        if ($cid > 0) {
            $datas['data'] = Permission::find($cid);
        }
        return view('admin.permission.index', $datas);
    }

    /**
     *新建权限页
     *
     *@param int $cid 层级id
     *@return void
     */
    public function create(int $cid)
    {
        $data = [];
        foreach ($this->fields as $field => $default) {
            $data[$field] = old($field, $default);
        }
        $data['cid'] = $cid;
        return view('admin.permission.create', $data);
    }

    /**
     *保存新建权限
     *
     *@param array $request 表单数据
     *@return void
     */
    public function store(PermissionCreateRequest $request)
    {

        $permission = new Permission();
        foreach (array_keys($this->fields) as $field) {
            $permission->$field = $request->get($field);
        }
        $permission->save();
        Event::fire(new permChangeEvent());
        return redirect('/admin/permission/' . $permission->cid)->withSuccess('添加成功！');
    }

    /**
     *展示权限
     *
     *@param int $cid 层级id
     *@return void
     */
    public function show($id)
    {
        //
    }

    /**
     *更新权限页
     *
     *@param int $id  权限id
     *@return void
     */
    public function edit($id)
    {
        $permission = Permission::find((int)$id);
        if (!$permission) return redirect('/admin/permission')->withErrors("找不到该权限!");
        $data = ['id' => (int)$id];
        foreach (array_keys($this->fields) as $field) {
            $data[$field] = old($field, $permission->$field);
        }
        return view('admin.permission.edit', $data);
    }

    /**
     *更新权限
     *
     *@param array $request 表单数据
     *@param int $id  权限id
     *@return void
     */
    public function update(PermissionUpdateRequest $request, $id)
    {
        $permission = Permission::find((int)$id);
        foreach (array_keys($this->fields) as $field) {
            $permission->$field = $request->get($field);
        }
        $permission->save();
        Event::fire(new permChangeEvent());
        return redirect('admin/permission/' . $permission->cid)->withSuccess('修改成功！');
    }

    /**
     *删除权限
     *
     *@param int $id 权限id
     *@return void
     */
    public function destroy($id)
    {
        $child = Permission::where('cid', $id)->first();

        if ($child) {
            return redirect()->back()
                ->withErrors("请先将该权限的子权限删除后再做删除操作!");
        }
        $tag = Permission::find((int)$id);
        if ($tag) {
            $tag->delete();
        } else {
            return redirect()->back()
                ->withErrors("删除失败");
        }
        Event::fire(new permChangeEvent());
        return redirect()->back()
            ->withSuccess("删除成功");
    }
}