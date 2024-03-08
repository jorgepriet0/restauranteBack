<?php

namespace App\Http\Controllers;

use App\Models\Horario;
use App\Models\Reserva;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\User;

class ReservaController extends Controller
{
    function index()
    {
        $horarios = Horario::all();
        $eventos = [];
        foreach ($horarios as $evento) {
            if ($evento->disponible == 1) {
                $eventos[] = [
                    'title' => $evento->hora,
                    'start' => $evento->fecha,
                    /* 'url' => "/restaurante/public/confirmarReserva/" . $evento->fecha . "  " . $evento->hora */ 
                ];
            }
        }
        return view('reservar', compact("eventos"));
    }

    public function misReservas()
    {
        $usuarioId = auth()->id();
        $reservas = Reserva::where('idUser', $usuarioId)->get();
        return view('misreservas', ['reservas' => $reservas]);
    }

    public function cancelarReserva(Request $request)
    {
        $id = $request->id;
        $reserva = Reserva::find($id);

        $idHora = $reserva->idHorario;

        $hora = Horario::find($idHora);
        $reserva->delete();

        $hora->disponible = true;
        $hora->save();

        $usuarioId = auth()->id();
        $reservas = Reserva::where('idUser', $usuarioId)->get();
        return view('misreservas', ['reservas' => $reservas]);
    }

}
