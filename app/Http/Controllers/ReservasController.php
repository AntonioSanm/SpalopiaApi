<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Horario;
use App\Reserva;
use DB;
use Error;

class ReservasController extends Controller
{
    public function makeReservation( Request $request)
    {
        $validator = Validator::make($request->all(), [
            'servicio_id' => 'required',
            'nombreCliente' => 'required',
            'comentarios' => 'required',
            'precio' => 'required',
            'dia' => 'required',
            'hora' => 'required'
        ]);

        $response = [];
                
        if ($validator->fails()) {
            $response['validation'] = $validator->errors();
            return $response;
        }                                   //validaciones
        
     
        if (!empty(DB::select( DB::raw("SELECT * FROM horarios WHERE servicio_id = '$request->servicio_id' AND '$request->dia' BETWEEN inicio and fin") ))){ //comprobamos que hay servicio para el dia y hora seleccionada
            if(empty(DB::select(DB::raw("SELECT * FROM reservas WHERE servicio_id = '$request->servicio_id' AND dia = '$request->dia' AND hora = '$request->hora' ")))){ //comprobamos que NO hay una reserva para el servicio en el dia y hora seleccionadas
                $reserva = new Reserva;
                $reserva->servicio_id = $request->servicio_id;
                $reserva->nombreCliente = $request->nombreCliente;
                $reserva->comentarios = $request->comentarios;
                $reserva->precio =  $request->precio;
                $reserva->dia = $request->dia;
                $reserva->hora = $request->hora;
                $reserva->timestamps = false;

                $reserva->save();

                $response['success'] = 'reserva con exito';
                return $response;
            }else {
                $response['error'] = 'ya esta reservado ese servicio en la fecha y hora seleccionada';
                return $response;
            }
        }else {
            $response['error'] = 'no hay servicio en la fecha y hora seleccionada';
            return $response;
        }

    }
}
