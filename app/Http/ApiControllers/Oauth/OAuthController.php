<?php
namespace App\Http\ApiControllers\Oauth;

use App\Http\ApiControllers\Controller;
use App\Http\Requests;
use Exception;
use LucaDegasperi\OAuth2Server\Authorizer;

class OAuthController extends Controller{
    protected $authorizer;

    public function __construct(Authorizer $authorizer){
        $this->authorizer = $authorizer;
    }

    /**
     *通过OAuth2获取API access_token
     *
     *@return void
     */
    public function accessToken() {
        try {
            return $this->authorizer->issueAccessToken();
        }catch (Exception $e) {
            return $this->response->errorUnauthorized('认证失败');
        }
    }

}
