<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Horario;
use Validator;
use DB;

class HorariosController extends Controller
{
    public function filterByDate(Request $request)
        {
            $validator = Validator::make($request->all(), [
                'start_date' => 'required',
                'end_date' => 'required'
            ]);

            if ($validator->fails()) {
                $response['validation'] = $validator->errors();
                return $response;
            }

            try {
                
                $start_date = \Carbon\Carbon::createFromFormat('d m Y H:i:s', $request->start_date);
                $end_date = \Carbon\Carbon::createFromFormat('d m Y H:i:s', $request->end_date);

            } catch (\Exception $e) {
                $response['error'] = 'Fecha inválida';
                return $response;
            }
            
            if($end_date->greaterThanOrEqualTo($start_date)){
                return Horario::whereBetween('inicio',[$start_date, $end_date ])->leftJoin('servicios', function($join)
                {
                    $join->on('horarios.servicio_id', '=', 'servicios.id');

                })->select(DB::raw('nombre, DATE_FORMAT(inicio, \'%m-%d-%Y\') as inicio, DATE_FORMAT(inicio, \'%H:%i\') as horaInicio, DATE_FORMAT(fin, \'%H:%i\') as horaFin '))->get();
            }else {
                $response['error'] = 'end date must be equal or greater than start date';
                return $response;
            }
        }
}
