<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;

/**
 * Controlador del API.
 * Solo muestra la lista de valores.
 */
class ApiController extends Controller
{
    /**
     * Mediante una api sobre el valor del euro en diferentes paises,
     * se recoge dicha api y se muestra en la vista api.blade.php
     *
     * @return void
     */
    public function lista()
    {
        $headers = [
            'Accepts: application/json',
        ];
        //URL de mi api encontraada:
        $url = 'https://api.exchangeratesapi.io/latest';
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_RETURNTRANSFER => 1
        ));

        $response = curl_exec($curl);
        $response = json_decode($response);

        //Guardo las respuestas en datos:
        $datos = [];
        $base= $response->base;
        $fecha=$response->date;
        $rates=$response->rates;

        $datos=[
            'base'=>$base,
            'fecha'=>$fecha,
            'rates'=>$rates  
        ];

        //Mando los datos a la vista
        return view('/extras/api',$datos); 
    }
}
