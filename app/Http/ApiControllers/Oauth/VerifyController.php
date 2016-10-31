<?php

namespace App\Http\ApiControllers\Oauth;

use Illuminate\Http\Request;
use Auth;
use App\Http\Requests;
use App\Http\ApiControllers\Controller;

class VerifyController extends Controller
{
    public function verify($username, $password)
    {
        $credentials = [
            'email' => $username,
            'password' => $password,
        ];

        if (Auth::once($credentials)) {
            return Auth::user()->id;
        } else {
            return false;
        }
    }
}
