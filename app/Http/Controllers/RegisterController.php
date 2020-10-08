<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use App\User;

class RegisterController extends Controller
{
    /**
    * List all users registered.
    *
    * @return \Illuminate\Http\Response
    */
    public function listAllRegistries(Request $request)
    {
        try {
            $usersData = DB::table('users')->orderBy('name')->get();
            $usersDatasArray = [];

            if (count($usersData) > 0) {
                foreach ($usersData as &$user) {
                    if ($user->admin != 1) {

                        $user->competences = Array();    
                        $competencesDataArray = DB::table('competences')->get()->where('user_id', $user->id);
                    
                        foreach ($competencesDataArray as &$competence) {
                            array_push($user->competences, array(
                                $competence->description
                            ));
                        };

                        array_push($usersDatasArray, $user);
                    }
                };
            }

            return response()->json($usersDatasArray, 200);

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Creating a new user register.
     *
     * @return \Illuminate\Http\Response
     */
    public function createUser(Request $request)
    {
        $messagesFormated = [
            'min' => '* O campo :attribute está no formato incorreto.',
            'max' => '* O campo está no formato incorreto.',
            'email' => '* :email está no formato incorreto',
            'unique' => '* Esse :attribute já está em uso.',
            'required' => '* Este campo é obrigatório.'
        ];

        $validatedData = $request->validate([
            'name'  => 'required|max:255|min:2',
            'email' => 'required|unique:users|email|max:255',
            'cpf'   => 'required|unique:users|min:14|max:14',  
            'competences' => 'required|min:1|max:3'
        ], $messagesFormated);

        $name  = trim($request->input('name'));
        $email = trim($request->input('email'));
        $cpf   = trim($request->input('cpf'));  
        $phone = str_replace(' ', '', $request->input('phone'));
        $competences = $request->input('competences');

        try {

            \DB::beginTransaction();

            $userId = DB::table('users')->insertGetId(array(
                'name'  => $name,
                'email' => $email,
                'cpf'   => $cpf,
                'phone' => $phone
            ));

            if (count($competences) > 0 ) {
                foreach ($competences as &$competence) {
                    DB::table('competences')->insert(array(
                        'user_id'     => $userId,
                        'description' => $competence['text']
                    ));
                }
            }

            \DB::commit();
            return response()->json('Usuário cadastrado com sucesso!', 200);

        } catch (\Throwable $th) {
            \DB::rollback();
            throw $th;
        }
    }

    // Only render the app componet
    public function render(Request $request)
    {
        return view('app');
    } 
}
