<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use App\User;

class RegisterController extends Controller
{
    /**
    * Display a listing of the resource and validate the registers.
    *
    * @return \Illuminate\Http\Response
    */
    public function register(Request $request)
    {
        try {
            $arrayCompetences = DB::table('competences')->get();
            return response()->view('app')->send(['competences' => $arrayCompetences]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function listAllRegistries(Request $request)
    {
        try {
            $usersDatasArray = [];
            $usersData = DB::table('users')->orderBy('name')->get();

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
            return response()->json($usersDatasArray);

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createUser(Request $request)
    {
        $messagesFormated = [
            'required' => '* Este campo é obrigatório.',
            'unique' => '* Esse :attribute já está em uso.',
            'min' => '* O campo :attribute está no formato incorreto.',
            'max' => '* O campo está no formato incorreto.',
            'email' => '* :email está no formato incorreto'
        ];

        $validatedData = $request->validate([
            'name'  => 'required|max:255|min:2',
            'email' => 'required|unique:users|email|max:255',
            'cpf'   => 'required|unique:users|min:14|max:14',  
            'competences' => 'required|min:1|max:3'
        ], $messagesFormated);

        $name  = $request->input('name');
        $email = $request->input('email');
        $cpf   = $request->input('cpf');  
        $phone = $request->input('phone');
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
            return response()->json('Usuário cadastrado com sucesso!');

        } catch (\Throwable $th) {
            \DB::rollback();
            throw $th;
        }
    }

    public function index(Request $request)
    {
        return view('app');
    } 
}
