<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\User;
use App\Models\Piece;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Auth;

class SaleController extends Controller
{
    /**
     * Muestra todas las ventas.
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

        //Necesitaremos estas variables apra mandar a la vista los usuarios y piezas y listarlos.
        $usersAll=User::all();
        $piecesAll = Piece::all();
        
        
        //Si no hay request o la request tiene más elementos a parte de la paginacióm, filtra.
        if(!$request|| isset($arr) && $request != $arr ){
            //Tipos de filtrado:
            $nombre= $request->get('buscaNombre');
            $idUser= $request->get('buscaUser');
            $idPiece= $request->get('buscaPiece');
            $fecha= $request->get('buscaFechaLogin');
            $precio= $request->get('buscaPrecio');
            
            //La venta con los filtros:
            $sales = Sale::nombre($nombre)->userId($idUser)->pieceId($idPiece)->fecha($fecha)->precio($precio)->paginate($page);

            //Hacemos control
            if(count($sales)==0){
                $array=[
                    'success' => false,
                    'message' => 'No existe venta con dichos datos en nuestra base de datos',
                    'usersAll' => $usersAll,
                    'piecesAll' => $piecesAll 
                ];
            }else{
                //Buscamos los usuarios y las piezas:
                foreach ($sales as $sale){
                    //Buscamos al user
                    foreach($usersAll as $user){
                        if($user->id == $sale ->user_id){
                            //Guardamos los encontrados en un array
                            $usersSales[]=[
                                "id"=>$user->id,
                                "email"=>$user->email
                            ];
                        }
                    };

                    //Buscamos la pieza
                    foreach($piecesAll as $piece){
                        if($piece->id == $sale ->piece_id){
                            //Guardamos los encontrados en un array 
                            $piecesSales[]=[
                                "id"=>$piece->id,
                                "name"=>$piece->name
                            ];
                        }
                    };
                };

                $array=[
                    'success' => true,
                    'sales'=>$sales,
                    'usersSales'=>$usersSales,
                    'piecesSales'=>$piecesSales,
                    'usersAll' => $usersAll,
                    'piecesAll' => $piecesAll
                ];
            }
            //Y mandamos a la vista
            return view('/sales/sales',compact('sales'),$array);
        }else{
        //Si no tiene request o la que tiene es solo de paginacion:
            //Listamos todas las ventas
            $sales = Sale::paginate($page);

            //Hacemos control
            if(!$sales){
                $array=[
                    'success' => false,
                    'message' => 'No existen ventas',
                    'usersAll' => $usersAll,
                    'piecesAll' => $piecesAll
                ];
            }else{
                //Buscamos los usuarios y las piezas:
                foreach ($sales as $sale){
                    //Buscamos al user
                    foreach($usersAll as $user){
                        if($user->id == $sale ->id){
                            //Guardamos los encontrados en un array 
                            $usersSales[]=[
                                "id"=>$user->id,
                                "email"=>$user->email
                            ];
                        }
                    };

                    //Buscamos la pieza
                    foreach($piecesAll as $piece){
                        if($piece->id == $sale ->id){
                            //Guardamos los encontrados en un array 
                            $piecesSales[]=[
                                "id"=>$piece->id,
                                "name"=>$piece->name
                            ];
                        }
                    };
                };

                $array=[
                    'success' => true,
                    'sales'=>$sales,
                    'usersSales'=>$usersSales,
                    'piecesSales'=>$piecesSales,
                    'usersAll' => $usersAll,
                    'piecesAll' => $piecesAll
                ];
            }
            //Devolvemos vista
            return view('/sales/sales',$array);
        }
       
    }

     /**
     * Muestra las ventas del usurio logueado.
     *
     * @return \Illuminate\Http\Response
     */
    public function listarMisVentas(Request $request)
    {
        if($request->get('pagination')){
            $page=$request->get('pagination');
            $arr['pagination']=$request->get('pagination');
        }else{
            $page=Config::get('constants.pagination');
            $arr['pagination']= $page; 
        }

        //Necesitaremos estas variables apra mandar a la vista los usuarios y piezas y listarlos.
        $piecesAll = Piece::all();

        //Si no hay request o la request tiene más elementos a parte de la paginacióm, filtra.
        if(!$request|| isset($arr) && $request != $arr ){
            //Tipos de filtrado:
            $nombre= $request->get('buscaNombre');
            $idPiece= $request->get('buscaPiece');
            $fecha= $request->get('buscaFechaLogin');
            $precio= $request->get('buscaPrecio');
            
            //La venta con los filtros. Siempre se buscará segun el id del usuario identificado
            $sales = Sale::userId(Auth::user()->id)->nombre($nombre)->pieceId($idPiece)->fecha($fecha)->precio($precio)->paginate($page);

            //Hacemos control
            if(count($sales)==0){
                $array=[
                    'success' => false,
                    'message' => 'No existen ventas.',
                    'piecesAll' => $piecesAll 
                ];
            }else{
                //Buscamos los usuarios y las piezas:
                foreach ($sales as $sale){

                    //Buscamos la pieza
                    foreach($piecesAll as $piece){
                        if($piece->id == $sale ->piece_id){
                            //Guardamos los encontrados en un array 
                            $piecesSales[]=[
                                "id"=>$piece->id,
                                "name"=>$piece->name
                            ];
                        }
                    };
                };

                $array=[
                    'success' => true,
                    'sales'=>$sales,
                    'piecesSales'=>$piecesSales,
                    'piecesAll' => $piecesAll
                ];
            }
            //Y mandamos a la vista
            return view('/sales/my-sales',compact('sales'),$array);
        }else{
        //Si no tiene request o la que tiene es solo de paginacion:
            //Listamos todas las ventas
            $sales = Sale::userId(Auth::user()->id)->paginate($page);

            //Hacemos control
            if(!$sales){
                $array=[
                    'success' => false,
                    'message' => 'No existen ventas',
                    'piecesAll' => $piecesAll
                ];
            }else{
                //Buscamos los usuarios y las piezas:
                foreach ($sales as $sale){
                    //Buscamos la pieza
                    foreach($piecesAll as $piece){
                        if($piece->id == $sale ->id){
                            //Guardamos los encontrados en un array 
                            $piecesSales[]=[
                                "id"=>$piece->id,
                                "name"=>$piece->name
                            ];
                        }
                    };
                };

                $array=[
                    'success' => true,
                    'sales'=>$sales,
                    'piecesSales'=>$piecesSales,
                    'piecesAll' => $piecesAll
                ];
            }
            //Devolvemos vista
            return view('/sales/my.sales',$array);
        }
       
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
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function show(Sale $sale)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function edit(Sale $sale)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sale $sale)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sale $sale)
    {
        //
    }
}
