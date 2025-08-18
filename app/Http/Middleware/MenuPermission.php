<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class MenuPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $permissionType): Response
    {
        $routeName = $request->route()->getName();
        $auth_user_id = Auth::user()->id;
        $user = User::with('role.permissions')->find($auth_user_id);
        if (!Auth::user() && $user->hasPermission($routeName, $permissionType)) {
            abort(403, 'Unauthorized action.');
        }
        return $next($request);
    }
}
