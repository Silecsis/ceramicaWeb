<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Carbon;

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


    //------------------FUNCIONES QUE REALIZA EL ADMIN--------------------//

     /**
     * Solo podrá acceder el type admin
     * Manda a la vista y todos los usuarios de la base de datos.
     * También manda a la vista mediante filtrado
     *
     * @return \Illuminate\Http\Response
     */
    public function listar(Request $request)
    {
        if($request->get('pagination')){
            $page=$request->get('pagination');
            $arr['pagination']=$request->get('pagination');
            Config::set('constants.pagination',$page);
        }else{
            $page=Config::get('constants.pagination');
            $arr['pagination']= $page; 
        }
        
        //Control de que no pueda acceder ningun socio
        if(Auth::user()->type == 'admin'){

            //Si no hay request o la request tiene más elementos a parte de la paginacióm, filtra.
            if(!$request|| isset($arr) && $request != $arr ){

                //Tipos de filtrado:
                $nombre= $request->get('buscaNombre');

                $email= $request->get('buscaEmail');

                $nick= $request->get('buscaNick');

                $fecha= $request->get('buscaFechaLogin');

                $tipo= $request->get('buscaTipo');

                //El usuario con los filtros:
                //$users = User::nombre($nombre)->email($email)->nick($nick)->fecha($fecha)->tipo($tipo)->paginate($page);
                $users = User::nombre($nombre)->email($email)->nick($nick)->fecha($fecha)->tipo($tipo)->paginate($page);
                
                //Hacemos control
                if(count($users)==0){
                    $array=[
                        'success' => false,
                        'message' => 'No existe usuario con dichos datos en nuestra base de datos'
                    ];
                }else{
                    $array=[
                        'success' => true,
                        'users'=>$users
                    ];
                }

                //Y mandamos a la vista
                return view('/users/users',compact('users'),$array);

            }else{
            //Si no tiene request o la que tiene es solo de paginacion:

                //Listamos todos los users
                $users = User::paginate($page);

                //Hacemos control
                if(!$users){
                    $array=[
                        'success' => false,
                        'message' => 'No existe usuario con dichos datos en nuestra base de datos'
                    ];
                }else{
                    $array=[
                        'success' => true,
                        'users'=>$users
                    ];
                }

                //Devolvemos vista
                return view('/users/users',$array);
            }
        }else{
            $array=[
                'window'=>'Home',
                'message' => 'No tiene permisos de administrador para acceder a dicha URL.'
            ];

            return view('/extras/error',$array);
        }
    }

    /**
     * Solo podrá acceder el type admin.
     * Manda a la vista de edición de usuario cargando sus datos en los campos.
     *
     * @param  \App\Models\User  $User
     * @return \Illuminate\Http\Response
     */
    public function showAdmin(Request $request)
    {
        //Control de que no pueda acceder ningun socio
        if(Auth::user()->type == 'admin'){
            //Recogemos el usuario mediante el id mandado.
            $id=$request->get('id');
            $user = User::find($id);

            //Sino existe, mandamos a página de error.
            if (!$user) {
                $array=[
                    'window'=>'Usuario -> Edición de usuario',
                    'message' => 'Usuario no encontrado'
                ];

            return view('/extras/error',$array);

            }else if($user && $user->id == Auth::user()->id){
                $array=[
                    'window'=>'Usuario -> Edición de usuario',
                    'message' => 'Para editar su perfil, utilice la configuración situada en el desplegable de su nombre, por favor.'
                ];

            return view('/extras/error',$array);

            }else{
                //Si existe, mandamos a la página de edición de usuario con los datos del usuario.
                $array=[
                    "user"=>$user
                ];
                return view('/users/edit-admin',$array);
            }
        }else{
            $array=[
                'window'=>'Home',
                'message' => 'No tiene permisos de administrador para acceder a dicha URL.'
            ];

            return view('/extras/error',$array);
        }
    }

    /**
     * Solo podrá acceder el type admin.
     * Actualiza el usuario desde la lista y volverá a la lista
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $User
     * @return \Illuminate\Http\Response
     */
    public function updateAdmin(Request $request)
    {
        //Control de que no pueda acceder ningun socio
        if(Auth::user()->type == 'admin'){
            //Recogemos el usuario mediante el id mandado.
            $id=$request->get('id');
            $user = User::find($id);
    
            //Sino existe, mandamos a página de error.
            if (!$user) {
                $array=[
                    'window'=>'Usuario -> Edición de usuario',
                    'message' => 'Usuario no encontrado'
                ];

            return view('/extras/error',$array);

            //Si el usuario intenta eliminarse a sí mismo, le dará error.
            }else if($user && $user->id == Auth::user()->id){
                $array=[
                    'window'=>'Usuario -> Edición de usuario',
                    'message' => 'Para editar su perfil, utilice la configuración situada en el desplegable de su nombre, por favor.'
                ];

            return view('/extras/error',$array);

            }else{
                //Si existe, primero validamos.   
                $request->validate([
                    'name' => 'required|string|max:255|min:6',
                    'email' => 'required|string|email|max:255|min:6|unique:users,email,' . $user->id,
                    'type' => 'required|string|max:10' . $user->id,
                    'nick' => 'required|string|max:255|min:4'
                    //'img' => 'required|min:4',
                 ]); 

                //Subir la imagen
                $image= $request->file('image'); 
                // Si recibimos un objeto imagen tendremos que utilizar el disco para almacenarla
                // Para ello utilizaremos un objeto storage de Laravel
                if($image){
                    // Generamos un nombre único para la imagen basado en time() y el nombre original de la imagen
                    $image_name =  time() . $image->getClientOriginalName();
                    // Seleccionamos el disco virtual users, extraemos el fichero de la carpeta temporal
                    // donde se almacenó y guardamos la imagen recibida con el nombre generado
                    Storage::disk('users')->put($image_name, File::get($image));
                    $user->img = $image_name;   
                } 
                
                $user->name = $request->name;
                $user->email = $request->email;
                $user->type = $request->type;
                $user->nick = $request->nick;

                //Si probamos a actualizar y funciona, lo redirigimos a la vista principal con un mensaje.
                if ($user->save()) { 
                    $array=[
                        'id'=>$user->id
                    ];
                    return redirect()->route('edit.admin', $array)->with(['status' => 'El usuario con email '.$user->email.' ha sido actualizado correctamente']);

                } else {
                //Sino funciona el guardar, se le manda a la vista de error con el mensaje.
                    $array=[
                        'window'=>'Usuario -> Edición de usuario',
                        'message' => 'El usuario no puede ser editado'
                    ];

                    return view('/extras/error',$array);
                }
            }
        }else{
            $array=[
                'window'=>'Home',
                'message' => 'No tiene permisos de administrador para acceder a dicha URL.'
            ];

            return view('/extras/error',$array);
        }
    }

    /**
     * Solo podrá acceder el type admin.
     *Elimina aun usuario de la tabla de datos y vuelve a la lista.
     *
     * @param  \App\Models\User  $User
     * @return \Illuminate\Http\Response
     */
    public function destroyAdmin(Request $request)
    {
        //Control de que no pueda acceder ningun socio
        if(Auth::user()->type == 'admin'){
            //Recogemos el usuario mediante el id mandado.
            $id=$request->get('id');
            $user = User::find($id);
    
            //Sino existe, mandamos a página de error.
            if (!$user) {
                $array=[
                    'window'=>'Usuario -> Eliminación de usuario',
                    'message' => 'Usuario no encontrado'
                ];

            return view('/extras/error',$array);

            //Si el usuario intenta eliminarse a sí mismo, le dará error.
            }else if($user && $user->id == Auth::user()->id){
                $array=[
                    'window'=>'Usuario -> Eliminación de usuario',
                    'message' => 'No te puedes eliminar a tí mismo'
                ];

            return view('/extras/error',$array);

            }else{
                //Si existe, recogemos el email del ususario.    
                $email=$user->email;

                //Si probamos a eliminar y funciona, lo redirigimos a la vista principal con un mensaje.
                if ($user->delete()) { 
                    return redirect()->route('users')->with(['status' => 'El usuario '.$email.' ha sido eliminado correctamente']);

                } else {
                //Sino funciona el delete, se le manda a la vista de error con el mensaje.
                    $array=[
                        'window'=>'Usuario -> Eliminación de usuario',
                        'message' => 'El usuario no puede ser eliminado'
                    ];

                    return view('/extras/error',$array);
                }
            }
        }else{
            $array=[
                'window'=>'Home',
                'message' => 'No tiene permisos de administrador para acceder a dicha URL.'
            ];

            return view('/extras/error',$array);
        }
        
    }

     /**
     * Solo podrá acceder el type admin.
     * Crea un nuevo usuario.
     *
     * @return \Illuminate\Http\Response
     */
    public function createAdmin(Request $request)
    {
        //Control de que no pueda acceder ningun socio
        if(Auth::user()->type == 'admin'){
    
            $user = new User();

            $request->validate([
                'name' => 'required|string|max:255|min:6',
                'email' => 'required|string|email|max:255|min:6|unique:users,email',
                'password' => 'required|string|confirmed|min:8',
                'type' => 'required|string|max:10',
                'nick' => 'required|string|max:255|min:2'
             ]); 

            //Subir la imagen
            $image= $request->file('image'); 
            // Si recibimos un objeto imagen tendremos que utilizar el disco para almacenarla
            // Para ello utilizaremos un objeto storage de Laravel
            if($image){
                // Generamos un nombre único para la imagen basado en time() y el nombre original de la imagen
                $image_name =  time() . $image->getClientOriginalName();
                // Seleccionamos el disco virtual users, extraemos el fichero de la carpeta temporal
                // donde se almacenó y guardamos la imagen recibida con el nombre generado
                Storage::disk('users')->put($image_name, File::get($image));
                $user->img = $image_name;   
            } 
            
            $user->name = $request->name;
            $user->email = $request->email;
            $user->type = $request->type;
            $user->nick = $request->nick;
            $user->password = Hash::make($request->password);
            $user->email_verified_at = Carbon::now()->format('Y-m-d H:i:s');
            $user->remember_token = 'remember'.$user->nick;

            //Si probamos a actualizar y funciona, lo redirigimos a la vista principal con un mensaje.
            if ($user->save()) {
                return redirect()->route('new.user')->with(['status' => 'El usuario se ha creado con éxito.']);

            } else {
            //Sino funciona el guardar, se le manda a la vista de error con el mensaje.
                $array=[
                    'window'=>'Usuario -> Nuevo usuario -> Creación',
                    'message' => 'El usuario no se ha podido crear'
                ];

                return view('/extras/error',$array);
            }
        }else{
            $array=[
                'window'=>'Home',
                'message' => 'No tiene permisos de administrador para acceder a dicha URL.'
            ];

            return view('/extras/error',$array);
        }
    }

    //------------------//FUNCIONES QUE REALIZA EL ADMIN--------------------//

    /**
     * Manda a la vista de actualizar el perfil logueado con los datos
     * del usuario cargados en los campos.
     *
     * @param  \App\Models\User  $User
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $id=$request->get('id');
        $user = User::find($id);

        //Sino existe, mandamos a página de error.
        if (!$user) {
            $array=[
                'window'=>'Usuario -> Edición de mi perfil',
                'message' => 'Usuario no encontrado'
            ];

            return view('/extras/error',$array);
        }else{
            //Si existe, controlamos que se este editando a sí mismo
            if(Auth::user()->id == $user->id){
                //Si existe, mandamos a la página de edición de usuario con los datos del usuario.
                $array=[
                    "user"=>$user
                ];
                return view('/users/edit-profile',$array);
                
            }else{
                $array=[
                    'window'=>'Home',
                    'message' => 'No puedes editar un perfil que no sea el tuyo.'
                ];
    
                return view('/extras/error',$array);
            }
        }
    }

    /**
     * Actualiza el perfil del usuario que está logado
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $User
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $User)
    {
        $id=$request->get('id');
        $user = User::find($id);

        //Sino existe, mandamos a página de error.
        if (!$user) {
            $array=[
                'window'=>'Usuario -> Edición de mi perfil',
                'message' => 'Usuario no encontrado'
            ];

            return view('/extras/error',$array);
        }else{
            //Si existe, controlamos que se este editando a sí mismo
            if(Auth::user()->id == $user->id){
                //Luego validamos.   
                $request->validate([
                    'name' => 'required|string|max:255|min:6',
                    'email' => 'required|string|email|max:255|min:6|unique:users,email,' . $user->id,
                    'password' => 'required|string|confirmed|min:8',
                    'nick' => 'required|string|max:255|min:4'
                 ]); 

                //Subir la imagen
                $image= $request->file('image'); 
                // Si recibimos un objeto imagen tendremos que utilizar el disco para almacenarla
                // Para ello utilizaremos un objeto storage de Laravel
                if($image){
                    // Generamos un nombre único para la imagen basado en time() y el nombre original de la imagen
                    $image_name =  time() . $image->getClientOriginalName();
                    // Seleccionamos el disco virtual users, extraemos el fichero de la carpeta temporal
                    // donde se almacenó y guardamos la imagen recibida con el nombre generado
                    Storage::disk('users')->put($image_name, File::get($image));
                    $user->img = $image_name;   
                } 
                
                $user->name = $request->name;
                $user->email = $request->email;
                $user->nick = $request->nick;
                $user->password = Hash::make($request->password);
                $user->email_verified_at = Carbon::now()->format('Y-m-d H:i:s');
                $user->remember_token = 'remember'.$user->nick;
                $user->updated_at = Carbon::now()->format('Y-m-d H:i:s');

                //Si probamos a actualizar y funciona, lo redirigimos a la vista de edicion de mi perfil con un mensaje.
                if ($user->save()) { 
                    $array=[
                        'id'=>$user->id
                    ];
                    return redirect()->route('edit.profile', $array)->with(['status' => 'Se ha actualizado el perfil correctamente']);

                } else {
                //Sino funciona el guardar, se le manda a la vista de error con el mensaje.
                    $array=[
                        'window'=>'Usuario -> Edición de mi perfil',
                        'message' => 'Ha habido un problema en el guardado de edición'
                    ];

                    return view('/extras/error',$array);
                }
            }else{
                $array=[
                    'window'=>'Home',
                    'message' => 'No puedes editar un perfil que no sea el tuyo.'
                ];
    
                return view('/extras/error',$array);
            }
        }
    }
    
    //------------------PARA IMAGENES--------------------//

    /**
     * Actualiza la imagen
     *
     * @param Request $request
     * @return void
     */
    public function updateImage(Request $request)
    {
      $user = User::find(Auth::user()->id);
      
      $request->validate([
         'name' => 'required|string|max:255',
         'surname' => 'required|string|max:255',
         'nick' => 'required|string|max:100|unique:users,nick,' . $user->id,
         'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
         'password' => 'required|string|confirmed|min:1',
      ]);

      
      //Subir la imagen
      $image= $request->file('image');
      // Si recibimos un objeto imagen tendremos que utilizar el disco para almacenarla
      // Para ello utilizaremos un objeto storage de Laravel
      if($image){
         // Generamos un nombre único para la imagen basado en time() y el nombre original de la imagen
         $image_name =  time() . $image->getClientOriginalName();
         // Seleccionamos el disco virtual users, extraemos el fichero de la carpeta temporal
         // donde se almacenó y guardamos la imagen recibida con el nombre generado
         Storage::disk('users')->put($image_name, File::get($image));
         $user->image = $image_name;   
        }   
        $user->name = $request->name;
        $user->surname = $request->surname;
        $user->nick = $request->nick;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        $user->save();

        return redirect()->route('config')->with(['status'=>'Configuración modificada con éxito']);
    }

    /**
     * Devuelve la imagen avatar del usuario
     *
     * @param [type] $filename
     * @return void
     */
    public function getImage($filename){     
        $file = Storage::disk('users')->get($filename);
        return new Response($file, 200);
    }
}
