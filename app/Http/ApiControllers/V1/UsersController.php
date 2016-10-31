<?php

namespace App\Http\ApiControllers\V1;

use Dingo\Api\Routing\Helpers;
use App\Http\Requests;
use LucaDegasperi\OAuth2Server\Authorizer;
use App\Http\ApiControllers\Controller;
use App\Models\User;

class UsersController extends Controller
{
	use Helpers;

    public function __construct()
    {
        $this->middleware('oauth');
        $this->scopes('read_user_data',array('index','show'));
    }

    /*
     *获取所有用户
     *@return array
     */
    public function index()
    {
        return User::all();
    }

    /*
     *通过access_token获取某个用户信息
     *@param obj $authorizer OAuth2授权对象
     *@return array
     */
    public function show(Authorizer $authorizer)
    {
        $uid=$authorizer->getResourceOwnerId(); // the token uid
        return User::findOrFail($uid);
    }

    /*
     *获取某个用户信息
     *@param int $uid 用户id
     *@return array
     */
    public function showByUid($uid)
    {
        return User::findOrFail($uid);
    }
}
