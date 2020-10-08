<?php

namespace App\Http\Middleware;
use DB;
use Closure;

class CheckUserAdmin
{
    /**
     * This Handle check if user was trying acess the 'validar' router is a admin.
     * If not, he its send to 'registrar' router. 
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $name = $request->route('name');
        $redirectRegister = redirect("/".$name."/registrar");

        if (!$name ) {
            return response()->json('Nenhum usuario foi encontrado!');
        }

        $existUser = DB::table('users')->where('name', $name)->get();

        if ($existUser) {
            if (count($existUser) == 1) {
                return ($existUser[0]->admin == 1) 
                            ? $next($request) 
                            : $redirectRegister;
            } else {
                foreach($existUser as &$user ) {
                    if ($user->admin == 1) {
                        $next($request); 
                    } continue;
                }
                return $redirectRegister;
            }
        } else {
           return $redirectRegister;
        }
    }
}
