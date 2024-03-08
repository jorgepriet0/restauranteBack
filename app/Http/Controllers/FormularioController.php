<?php

namespace App\Http\Controllers;

use App\Models\Horario;
use App\Models\Reserva;
use App\Mail\ContactoMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class FormularioController extends Controller
{
    public function index(Request $request, $fecha, $hora)
    {
        return view('confirmarReserva')->with(['fecha' => $fecha, 'hora' => $hora]);
    }

    public function SendEmail(Request $request)
    {
        if (Auth::check()) {
            $fecha = $request['fecha'];
            $hora = $request['hora'];
            $h = "'$hora'";
            $num = $request['num'];
            $menu = $request['menu'];
            $idHorario = DB::table('horario')->where('fecha', $fecha)->where('hora', $hora)->value('id');
            Reserva::create([
                "fecha" => $fecha,
                "hora" => $h,
                "num_comensales" => $num,
                "idHorario" => $idHorario,
                "idMenu" => $menu,
                'idUser' => Auth::user()->id,
                "created_at" => now(),
                "updated_at" => now()
            ]);
            DB::table('horario')->where('fecha', $fecha)->where('hora', $hora)->update(['disponible' => false]);
            $usuarioId = auth()->id();
            $reservas = Reserva::where('idUser', $usuarioId)->get();
            
        } else {
            $fecha = $request['fecha'];
            $hora = $request['hora'];
            $h = "'$hora'";
            $num = $request['num'];
            $menu = $request['menu'];
            $idHorario = DB::table('horario')->where('fecha', $fecha)->where('hora', $hora)->value('id');
            Reserva::create([
                "fecha" => $fecha,
                "hora" => $h,
                "num_comensales" => $num,
                "idHorario" => $idHorario,
                "idMenu" => $menu,
                'idUser' => null,
                "created_at" => now(),
                "updated_at" => now()
            ]);
        }
        
        return response()->json("Reserva Realizada Correctamente");
        
    }


}
