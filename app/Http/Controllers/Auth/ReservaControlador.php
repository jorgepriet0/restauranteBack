<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Horario;
use App\Models\Reserva;
use App\Models\Tarjeta;
use App\Mail\ContactoMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Laravel\Sanctum\PersonalAccessToken;

class ReservaControlador extends Controller
{
    /**
     * La función `getDatos` recupera datos del usuario y tarjetas asociadas en función de un token
     * proporcionado.
     * 
     * @param Request data La función `getDatos` toma como parámetro un objeto `Request`. En el
     * contexto de Laravel, el objeto `Solicitud` representa una solicitud HTTP que ingresa a la
     * aplicación.
     * 
     * @return $La función `getDatos` devuelve una respuesta JSON con el ID del usuario, nombre, correo
     * electrónico y una colección de tarjetas asociadas con el usuario. Si el token proporcionado en
     * la solicitud es válido y corresponde a un usuario, la función recupera la información del
     * usuario y sus tarjetas de la base de datos y la devuelve en formato JSON.
     */
    public function getDatos(Request $data)
    {
        $token = PersonalAccessToken::findToken($data["token"]);
        if ($token) {
            $user = $token->tokenable;
            $tarjetas = Tarjeta::where('idUser', $user->id)->get();
            return response()->json([
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'tarjetas' => $tarjetas
            ]);
        }
    }

    /**
     * La función `reservaUsuario` maneja las reservas de los usuarios, creando una reserva si se
     * proporciona un token válido o enviando un correo electrónico de confirmación en caso contrario.
     * 
     * @param Request request La función `reservaUsuario` que proporcionó parece manejar el proceso de
     * reserva para un usuario. Primero verifica si el token proporcionado en la solicitud es válido
     * buscándolo usando el modelo `PersonalAccessToken`. Si se encuentra el token, recupera el usuario
     * asociado con el token y procede a crear
     * 
     * @return $json La función `reservaUsuario` está devolviendo una respuesta JSON con el mensaje "Reserva
     * Realizada Correctamente" después de procesar la solicitud de reserva.
     */
    public function reservaUsuario(Request $request)
    {
        //PRUEBA COMMIT REALIZADO
        $data = $request->all();
        $token = PersonalAccessToken::findToken($data["token"]);

        if ($token) {
            $user = $token->tokenable;
            $idHorario = DB::table('horario')->where('fecha', $data['fecha'])->where('hora', $data['hora'])->value('id');
            Reserva::create([
                "fecha" => $data['fecha'],
                "hora" => $data['hora'],
                "num_comensales" => $data['num'],
                "idHorario" => $idHorario,
                "idMenu" => $data['idMenu'],
                'idUser' => $user->id,
                'idTarjeta' => $data['tarjeta'],
                "created_at" => now(),
                "updated_at" => now()
            ]);
            DB::table('horario')->where('fecha', $data['fecha'])->where('hora', $data['hora'])->update(['disponible' => false]);
        } else {
            $correo = $request->input('correo');
            Mail::raw('Reserva realizada correctamente', function ($message) use ($correo) {
                $message->to($correo)
                    ->subject('Reserva realizada correctamente');
            });

            $idHorario = DB::table('horario')->where('fecha', $data['fecha'])->where('hora', $data['hora'])->value('id');
            Reserva::create([
                "fecha" => $data['fecha'],
                "hora" => $data['hora'],
                "num_comensales" => $data['num'],
                "idHorario" => $idHorario,
                "idMenu" => $data['idMenu'],
                'idUser' => 1,
                'idTarjeta' => $data['tarjeta'],
                "created_at" => now(),
                "updated_at" => now()
            ]);
            DB::table('horario')->where('fecha', $data['fecha'])->where('hora', $data['hora'])->update(['disponible' => false]);
        }
        return response()->json("Reserva Realizada Correctamente");
    }
    
    /**
     * Esta función PHP recupera reservas asociadas con un usuario en función de un token
     * proporcionado.
     * 
     * @param Request request La función `misReservas` toma como parámetro un objeto `Request`. Este
     * objeto `Solicitud` contiene todos los datos enviados con la solicitud, como entradas de
     * formularios, encabezados y archivos. En este caso, la función recupera los datos de la solicitud
     * utilizando el método `all()`.
     * 
     * @return $json una respuesta JSON con estado verdadero y una lista de reservas (reservas) asociadas con
     * el usuario cuyo token se proporcionó en la solicitud.
     */
    public function misReservas(Request $request)
    {
        $data = $request->all();
        $token = PersonalAccessToken::findToken($data["token"]);
        if ($token) {
            $user = $token->tokenable;
            $reservas = Reserva::where('idUser', $user->id)->get();
            return response()->json([
                'status' => true,
                'reservas' => $reservas
            ], 200);
        }
    }
    /**
     * La función `reservasDisponibles` recupera las reservas disponibles de una lista de todos los
     * horarios y las devuelve en formato JSON.
     * 
     * @return $Se devuelve como respuesta JSON una serie de reservas disponibles con su título (hora) y
     * fecha de inicio (fecha).
     */
    function reservasDisponibles()
    {
        $horarios = Horario::all();
        $eventos = [];
        foreach ($horarios as $evento) {
            if ($evento->disponible == 1) {
                $eventos[] = [
                    'title' => $evento->hora,
                    'start' => $evento->fecha,
                ];
            }
        }
        return response()->json($eventos);
    }

    /**
     * La función `deleteReserva` elimina una reserva según el ID proporcionado después de verificar el
     * token y actualizar la disponibilidad de un intervalo de tiempo.
     * 
     * @param Request request La función `deleteReserva` que proporcionó se utiliza para eliminar una
     * reserva según los datos de la solicitud. Aquí hay una explicación de los parámetros utilizados
     * en la función:
     * 
     * @return $La función `deleteReserva` devuelve una respuesta JSON. Si la reserva se elimina
     * correctamente, devuelve una respuesta JSON con el resultado de la operación de eliminación. Si
     * no se encuentra la reserva, devuelve una respuesta JSON con un mensaje de error que indica que
     * no se encontró la reserva, junto con un código de estado 404.
     */
    public function deleteReserva(Request $request)
    {
        $data = $request->all();
        $token = PersonalAccessToken::findToken($data["token"]);
        if ($token) {
            $idReserva = $request["id"];
            $reserva = Reserva::where('id', $idReserva)->first(); // O también puedes usar get() si esperas múltiples resultados
            if ($reserva) {
                DB::table('horario')->where('fecha', $reserva->fecha)->where('hora', $reserva->hora)->update(['disponible' => true]);
                $delete = $reserva->delete();
                return response()->json($delete);
            } else {
                return response()->json(['error' => 'Reserva no encontrada'], 404);
            }
        }
    }

    /**
     * La función `misTarjetas` recupera las tarjetas de un usuario basándose en un token proporcionado
     * en PHP.
     * 
     * @param Request request La función `misTarjetas` parece ser un método controlador de Laravel que
     * espera un objeto `Request` como parámetro. El objeto `Solicitud` contiene todos los datos
     * enviados con la solicitud HTTP.
     * 
     * @return $La función `misTarjetas` devuelve una respuesta JSON que contiene las tarjetas del
     * usuario si el token es válido y está asociado con un usuario, o un mensaje de error "Error al
     * obtener las tarjetas" si no se encuentra el token.
     */
    function misTarjetas(Request $request)
    {
        $data = $request->all();
        $token = PersonalAccessToken::findToken($data["token"]);
        if ($token) {
            $user = $token->tokenable;
            $tarjetas = Tarjeta::where('idUser', $user->id)->get();
            return response()->json($tarjetas);
        } else {
            return response()->json("Error al obtener las tarjetas");
        }
    }

    /**
     * La función crea una nueva entrada de tarjeta en la base de datos asociada con un usuario en
     * función de los datos de solicitud proporcionados y la validación del token.
     * 
     * @param Request request La función `crearTarjeta` se utiliza para crear un nuevo registro en la
     * tabla `tarjeta` en base a los datos proporcionados en la solicitud. A continuación se muestra un
     * desglose de los parámetros utilizados en la función:
     * 
     * @return $una respuesta JSON que contiene el resultado de insertar los detalles de la tarjeta en
     * la tabla de la base de datos 'tarjeta'.
     */
    public function crearTarjeta(Request $request)
    {
        $data = $request->all();
        $token = PersonalAccessToken::findToken($data["token"]);

        if ($token) {
            $user = $token->tokenable;
            $insert = DB::table('tarjeta')->insert([
                'nombre' => $data["name"],
                'numero' => $data["number"],
                'cvv' => $data["cvc"],
                'fecha_caducidad' => $data["expiry"],
                'idUser' => $user->id,
                "created_at" => now(),
                "updated_at" => now()
            ]);

            return response()->json($insert);
        }
    }
    /**
     * Esta función PHP elimina una tarjeta específica asociada con un usuario según el token
     * proporcionado y la identificación de la tarjeta.
     * 
     * @param Request request La función `eliminarTarjeta` se utiliza para eliminar una tarjeta según
     * el token proporcionado y el ID de la tarjeta. A continuación se muestra un desglose de los
     * parámetros utilizados en la función:
     * 
     * @return $El código devuelve una respuesta JSON con el resultado de la operación de eliminación.
     * La respuesta contendrá un valor booleano que indica si la eliminación se realizó correctamente o
     * no.
     */
    public function eliminarTarjeta(Request $request)
    {
        $data = $request->all();
        $token = PersonalAccessToken::findToken($data["token"]);
        if ($token) {
            $user = $token->tokenable;
            $idTarjeta = $request["id"];
            $tarjeta = Tarjeta::where('idUser', $user->id)->where('id', $idTarjeta);
            $delete = $tarjeta->delete();
            return response()->json($delete);
        }
    }
}
