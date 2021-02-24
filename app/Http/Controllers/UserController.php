<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{


    /**
    * Crea una nueva instancia del controlador
    */
    public function __construct()
    {
        //Garantiza que los métodos del controlador sean con usuario autenticado. Esto se puede hacer también en la ruta
        $this->middleware('auth');   
    }

     /**
     * Manda a la vista y todos los usuarios de la base de datos
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::paginate(5);

        if(!$users){
            $array=[
                'success' => false
            ];
        }else{
            $array=[
                'success' => true,
                'users'=>$users
            ];
        }

        
        return view('/users/users',$array);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $User
     * @return \Illuminate\Http\Response
     */
    public function show(User $User)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $User
     * @return \Illuminate\Http\Response
     */
    public function edit(User $User)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $User
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $User)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $User
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
 
        if (!$user) {
            $array=[
                'window'=>'Usuario',
                'message' => 'Usuario no encontrado'
            ];

         return view('/extras/error',$array);

        }else{
            $email=$user->email;
            if ($user->delete()) { 


                return redirect()->route('users')->with(['status' => 'El usuario '.$email.' ha sido eliminado correctamente']);

            } else {
                $array=[
                    'window'=>'Usuario',
                    'message' => 'El usuario no puede ser eliminado'
                ];

                return view('/extras/error',$array);
            }
        }
    }
}
