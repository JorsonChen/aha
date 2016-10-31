<?php

namespace App\Http\AdminControllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\AdminControllers\Controller;
use App\Models\Role;
use App\Models\User;

class UserController extends Controller
{
    protected $fields = [
        'name' => '',
        'email' => '',
        'roles' => [],
    ];

    /**
     *用户列表
     *
     *@param obj $request 请求数据
     *@return json
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
            $data['recordsTotal'] = User::count();
            if (strlen($search['value']) > 0) {
                $data['recordsFiltered'] = User::where(function ($query) use ($search) {
                    $query->where('name', 'LIKE', '%' . $search['value'] . '%')
                        ->orWhere('email', 'like', '%' . $search['value'] . '%');
                })->count();
                $data['data'] = User::where(function ($query) use ($search) {
                    $query->where('name', 'LIKE', '%' . $search['value'] . '%')
                        ->orWhere('email', 'like', '%' . $search['value'] . '%');
                })
                    ->skip($start)->take($length)
                    ->orderBy($columns[$order[0]['column']]['data'], $order[0]['dir'])
                    ->get();
            } else {
                $data['recordsFiltered'] = User::count();
                $data['data'] = User::
                skip($start)->take($length)
                    ->orderBy($columns[$order[0]['column']]['data'], $order[0]['dir'])
                    ->get();
            }
            return response()->json($data);
        }
        return view('admin.user.index');
    }

    /**
     *新建用户页
     *
     *@return void
     */
    public function create()
    {
        $data = [];
        foreach ($this->fields as $field => $default) {
            $data[$field] = old($field, $default);
        }
        $data['rolesAll'] = Role::all()->toArray();
        return view('admin.user.create', $data);
    }

    /**
     *保存新建用户
     *
     *@param obj $request 请求数据
     *@return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = new User();
        foreach (array_keys($this->fields) as $field) {
            $user->$field = $request->get($field);
        }
        if ($request->get('password') != '' && $request->get('repassword') != '' && $request->get('password') == $request->get('repassword')) {
            $user->password = bcrypt($request->get('password'));
        } else {
            return redirect()->back()->withErrors('密码或确认密码不能为空！');
        }
        unset($user->roles);
        $user->save();
        if (is_array($request->get('roles'))) {
            $user->giveRoleTo($request->get('roles'));
        }
        return redirect('/admin/user')->withSuccess('添加成功！');
    }

    /**
     *展示某个用户
     *
     *@param int $id 用户id
     *@return void
     */
    public function show($id)
    {
        //
    }

    /**
     *编辑用户页
     *
     *@param int $id 用户id
     *@return void
     */
    public function edit($id)
    {
        $user = User::find((int)$id);
        if (!$user) return redirect('/admin/user')->withErrors("找不到该用户!");
        $roles = [];
        if ($user->roles) {
            foreach ($user->roles as $v) {
                $roles[] = $v->id;
            }
        }
        $user->roles = $roles;
        foreach (array_keys($this->fields) as $field) {
            $data[$field] = old($field, $user->$field);
        }
        $data['rolesAll'] = Role::all()->toArray();
        $data['id'] = (int)$id;
        return view('admin.user.edit', $data);
    }

    /**
     *保存更新用户信息
     *
     *@param obj $request 请求数据
     *@param int $id 用户id
     *@return void
     */
    public function update(Request $request, $id)
    {

        $user = User::find((int)$id);
        foreach (array_keys($this->fields) as $field) {
            $user->$field = $request->get($field);
        }
        if ($request->get('password') != '' || $request->get('repassword') != '') {
            if ($request->get('password') != '' && $request->get('repassword') != '' && $request->get('password') == $request->get('repassword')) {
                $user->password = bcrypt($request->get('password'));
            } else {
                return redirect()->back()->withErrors('修改密码时,密码或确认密码不能为空！');
            }
        }

        unset($user->roles);
        
        $user->save();
        $user->giveRoleTo($request->get('roles',[]));

        return redirect('/admin/user')->withSuccess('修改成功！');
    }

    /**
     *删除用户
     *
     *@param int $id 用户id
     *@return void
     */
    public function destroy($id)
    {
        $tag = User::find((int)$id);
        if ($tag && $tag->id != 1) {
            $tag->delete();
        } else {
            return redirect()->back()
                ->withErrors("删除失败");
        }

        return redirect()->back()
            ->withSuccess("删除成功");
    }
}
