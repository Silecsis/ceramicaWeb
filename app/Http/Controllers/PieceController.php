<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Piece;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PieceController extends Controller
{
    /**
     * Lista todas las piezas del sistema
     *
     * @return \Illuminate\Http\Response
     */
    public function listar(Request $request)
    {
        if($request->get('pagination')){
            $page=$request->get('pagination');
            $arr['pagination']=$request->get('pagination');
        }else{
            $page=Config::get('constants.pagination');
            $arr['pagination']= $page; 
        }

        //Necesitaremos estas variables apra mandar a la vista los usuarios y listarlos.
        $usersAll=User::all();
        
        
        //Si no hay request o la request tiene más elementos a parte de la paginacióm, filtra.
        if(!$request|| isset($arr) && $request != $arr ){
            //Tipos de filtrado:
            $nombre= $request->get('buscaNombre');
            $idUser= $request->get('buscaUser');
            $vendido= $request->get('buscaVendido');
            $fecha= $request->get('buscaFechaLogin');
            
            //La pieza con los filtros:
            $pieces = Piece::nombre($nombre)->userId($idUser)->vendido($vendido)->fecha($fecha)->paginate($page);

            //Hacemos control
            if(count($pieces)==0){
                $array=[
                    'success' => false,
                    'message' => 'No existen piezas con dichos datos en nuestra base de datos',
                    'usersAll' => $usersAll,
                ];
            }else{
                //Buscamos los usuarios y las piezas:
                $array=[
                    'success' => true,
                    'pieces'=>$pieces,
                    'usersAll' => $usersAll
                ];
            }
            //Y mandamos a la vista
            return view('/pieces/pieces',compact('pieces'),$array);
        }else{
        //Si no tiene request o la que tiene es solo de paginacion:
            //Listamos todas las ventas
            $pieces = Piece::paginate($page);

            //Hacemos control
            if(!$pieces){
                $array=[
                    'success' => false,
                    'message' => 'No existen piezas con dichos datos en nuestra base de datos',
                    'usersAll' => $usersAll
                ];
            }else{
                //Buscamos los usuarios y las piezas:
                
                $array=[
                    'success' => true,
                    'pieces'=>$pieces,
                    'usersAll' => $usersAll
                ];
            }
            //Devolvemos vista
            return view('/pieces/pieces',$array);
        }
    }

    /**
     * Lista las piezas del usuario registrado
     *
     * @return \Illuminate\Http\Response
     */
    public function listarMisPiezas(Request $request)
    {
        if($request->get('pagination')){
            $page=$request->get('pagination');
            $arr['pagination']=$request->get('pagination');
        }else{
            $page=Config::get('constants.pagination');
            $arr['pagination']= $page; 
        }

        //Si no hay request o la request tiene más elementos a parte de la paginacióm, filtra.
        if(!$request|| isset($arr) && $request != $arr ){
            //Tipos de filtrado:
            $nombre= $request->get('buscaNombre');
            $idUser= $request->get('buscaUser');
            $vendido= $request->get('buscaVendido');
            $fecha= $request->get('buscaFechaLogin');
            
            //La pieza con los filtros:
            $pieces = Piece::userId(Auth::user()->id)->nombre($nombre)->vendido($vendido)->fecha($fecha)->paginate($page);

            //Hacemos control
            if(count($pieces)==0){
                $array=[
                    'success' => false,
                    'message' => 'No existen Piezas.',
                ];
            }else{

                $array=[
                    'success' => true,
                    'pieces'=>$pieces,
                ];
            }
            //Y mandamos a la vista
            return view('/pieces/my-pieces',compact('pieces'),$array);
        }else{
        //Si no tiene request o la que tiene es solo de paginacion:
            //Listamos todas las piezas
            $pieces = Piece::userId(Auth::user()->id)->paginate($page);

            //Hacemos control
            if(!$pieces){
                $array=[
                    'success' => false,
                    'message' => 'No existen piezas'
                ];
            }else{

                $array=[
                    'success' => true,
                    'pieces'=>$pieces,
                ];
            }
            //Devolvemos vista
            return view('/pieces/my-pieces',$array);
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function sold(Request $request)
    {
        
        //Auth::user()->id == $piece->id
        $piece = Piece::find($request->get('id'));
        //Control de que no pueda acceder ningun socio

            //Sino existe, mandamos a página de error.
            if (!$piece) {
                $array=[
                    'window'=>'Mis piezas -> Proceso de venta',
                    'message' => 'Pieza no encontrada'
                ];

            return view('/extras/error',$array);

            }else if($piece && $piece->id != Auth::user()->id){
                $array=[
                    'window'=>'Mis piezas -> Proceso de venta',
                    'message' => 'No puede acceder a una pieza que no es suya.'
                ];

            return view('/extras/error',$array);

            }else{
                //Si existe, mandamos a la página de edición de usuario con los datos del usuario.
                $array=[
                    "piece"=>$piece
                ];
                return view('/pieces/sold',$array);
            }
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
     * @param  \App\Models\Piece  $piece
     * @return \Illuminate\Http\Response
     */
    public function detail(Request $request)
    {
        $id=$request->get('id');
        $piece = Piece::find($id);

        //Sino existe, mandamos a página de error.
        if (!$piece) {
            $array=[
                'window'=>'Usuario -> Piezas de cada usuario -> Ver en detalle',
                'message' => 'Pieza no encontrada'
            ];

            return view('/extras/error',$array);
        }else{
            //Si existe, mandamos a la página de edición de usuario con los datos del usuario.
            $array=[
                "piece"=>$piece
            ];
            return view('/pieces/detail',$array);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Piece  $piece
     * @return \Illuminate\Http\Response
     */
    public function edit(Piece $piece)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Piece  $piece
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Piece $piece)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Piece  $piece
     * @return \Illuminate\Http\Response
     */
    public function destroy(Piece $piece)
    {
        //
    }

     /**
    * Devuelve la imagen avatar del usuario
    *
    * @param [type] $filename
    * @return void
    */
    public function getImage($filename){     
        $file = Storage::disk('pieces')->get($filename);
        return new Response($file, 200);
     }
}
