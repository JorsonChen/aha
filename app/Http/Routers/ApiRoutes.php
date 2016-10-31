<?php

/**
 * OAuth
 */
Route::post('oauth/access_token', function() {
 return Response::json(Authorizer::issueAccessToken());
});

Route::get('/register',function(){$user = new App\Models\User();
 $user->name="tester";
 $user->email="test@test.com";
 $user->password = \Illuminate\Support\Facades\Hash::make("password");
 $user->save();
});


/**
 * Api
 */
$api = app('Dingo\Api\Routing\Router');

$api->version('v1', ['namespace' => 'App\Http\ApiControllers','middleware' => 'oauth'], function ($api) {

    //$api->get('/dingo',function(){
        //return "hello world";
    //});

    //controller中使用access_token
    $api->get('users/c', 'V1\UsersController@show');

    //router中使用access_token
    //$api->get('users/r', function () {
        ////$request = app('request')->toArray();
        ////$request = app('Dingo\Api\Routing\Router');
        ////$request = app('request')->headers();
        //$request = app('request')->toArray();
        //var_export($request);exit;

        //$uid = Authorizer::getResourceOwnerId(); // the token user_id
        //$users = new App\Http\Controllers\Api\V1\UsersController();
        //$user = $users->showByUid($uid);// get the user data from database
        //return Response::json($user);
    //});

    //oauth
    //$api->post('users/access_token','Oauth\OAuthController@accessToken');
    //$api->get('/no_access',function(){
    //return "no_access";
    //});


});

$api->version('v1',function ($api) {

    //Dingo 自定义抛出异常
    //$api->post('/no_access',function(){
            //$rules = [
                //'username' => ['required', 'alpha'],
                //'password' => ['required', 'min:7']
            //];

            //$payload = app('request')->only('username', 'password');

            //$validator = app('validator')->make($payload, $rules);

            //if ($validator->fails()) {
                //throw new Dingo\Api\Exception\StoreResourceFailedException('Could not create new user.', $validator->errors());
            //}
    //});

    $api->get('users/{uid}', function ($uid) {
        $usersApi = new ApiSrc\Api\V1\UsersApi();
        $user = $usersApi->showByUid($uid);
        return $user;
    });

    //$api->post('users/access_token','App\Http\ApiControllers\Oauth\OAuthController@accessToken');

    //$api->post('users/access_token', 'ApiSrc\Api\V1\UsersApi@getAccessToken');
    //$api->post('users/access_token', function () {
        //$usersApi = new ApiSrc\Api\V1\UsersApi();
        //try {
            //$accessToken = Authorizer::issueAccessToken();
            //return $usersApi->apiSuccessPackage($accessToken);
        //} catch (Exception $e) {
            //return $usersApi->handleException($e);
        //}
    //});

    //获取access_token
    $api->post('users/access_token', function (LucaDegasperi\OAuth2Server\Authorizer $authorizer) {
        $usersApi = new ApiSrc\Api\V1\UsersApi();
        $accessToken = $usersApi->getAccessToken($authorizer);
        return $accessToken;
    });

});

$api->version('v1', ['middleware' => 'oauth'], function ($api) {
    $api->get('users', function () {
        $uid = Authorizer::getResourceOwnerId(); // the token user_id
        //$usersApi = new UsersApi();
        $usersApi = new ApiSrc\Api\V1\UsersApi();
        $user = $usersApi->showByUid($uid);// get the user data from database
        return $user;
    });
});
