<?php

namespace App\Http\Middleware;

use Closure;
use Zizaco\Entrust\EntrustFacade as Entrust;
use Route,URL,Auth;
use App\Http\Middleware\GetMenu;

class AuthenticateAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  string|null $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        //return $next($request);
        if(Auth::guard('web')->user()->id === 1){
            return $next($request);
        }

        $previousUrl = URL::previous();
        $comData = (new GetMenu())->getMenu();
        if(!Auth::guard('web')->user()->can(Route::currentRouteName())) {
            if($request->ajax() && ($request->getMethod() != 'GET')) {
                return response()->json([
                    'status' => -1,
                    'code' => 403,
                    'msg' => '您没有权限执行此操作'
                ]);
            } else {
                return response()->view('admin.errors.403', compact('previousUrl','comData'));
            }
        }

        return $next($request);
    }
}
