<?php

namespace App\Http\Middleware;
use DB;
use Closure;

class CheckUserAdmin
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
        $name = $request->route('name');
        $redirectRegister = redirect("/".$name."/registrar");

        if (!$name ) {
            return response()->json('Nenhum usuario para acesso!');
        }

        $existUser = DB::table('users')->where('name', 'like', '%'.$name.'%')->get();

        if ($existUser) {
            if (count($existUser) == 1) {
                return ($existUser[0]->admin == 1) 
                ? $next($request) 
                : $redirectRegister; //response()->json('Usuário não autorizado!');
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
