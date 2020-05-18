<?php

namespace App\Http\Middleware;

use Closure;
use Auth, DB;
use App\Model\Url\Url;
use App\Model\RoleToUser\RoleToUser;

class UserRolePermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $requestUrl = $_SERVER['REQUEST_URI'];
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $userId = Auth::user()->id;

        if($userId == 1){
            return $next($request);
        }

        if($requestMethod == 'DELETE'){
            $urlEx = explode('/', $requestUrl);
            $requestUrl = $urlEx[0].'/'. $urlEx[1]. '/'. $urlEx[2];
        }

        // $userRole = RoleToUser::where('user_id', $userId)->get();
        // $urlRole = Url::with('role')->where('url', 'like', "%".$requestUrl)->where('action_type', $requestMethod)->get();
        // return response()->json($urlRole);
        
        $permissions = DB::table('urls')
            ->join('url_to_roles', 'urls.id', '=', 'url_to_roles.url_id')
            ->join('role_to_users', 'url_to_roles.role_id', '=', 'role_to_users.role_id')
            ->select('urls.*', 'url_to_roles.role_id', 'role_to_users.user_id')
            ->where('urls.url', 'like', "%".$requestUrl)
            ->where('urls.action_type', $requestMethod)
            ->where('role_to_users.user_id', $userId)
            ->get();
        // return response()->json($permissions);
        if(count($permissions) >= 1){
            return $next($request);
        }else{
            $responseData['error'] = 1; 
            $responseData['statusCode'] = 403;
            $responseData['errorMsg'] = "You don't have the permission to access it.";
            $responseData['data'] = "" ;
            return response()->json($responseData);
        }
        
    }
}
