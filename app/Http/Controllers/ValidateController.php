<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use App\User;

class ValidateController extends Controller
{
    /*
    * update status validate user.
    *
    * @return \Illuminate\Http\Response
    */
    public function validateUser(Request $request, $id){ 
        //validate
        if (!$id) {
            return response()->json('Nenhum Usuario passado!', 500);
        }

        $userId = $id;

        try {
            \DB::beginTransaction();
            $user   = DB::table('users')
                        ->where('id', $userId)
                            ->update(['validate' => true]);
            \DB::commit();
            return response()->json('The user was successfully update');
        } catch (\Throwable $th) {
            \DB::rollback();
            throw $th;
        }
    }

}
