<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Restaurante - Formulario de Contacto</title>
    <style>
        *{
            font-size: 20px;
        }
        img {
            width: 20px
        }
    </style>
</head> 
<body>
     <!-- Método en el que ya le hemos pasado el evento seleccionado con su fecha y hora para enviar el correo -->
     <form action="{{route('confirmarReserva.SendMail')}}" method="get" id="formulario1">
        Nombre: <input type="text" name="nombre" id="nombre"><br>
        Asunto: <input type="text" name="asunto" id="asunto"><br>
        Email: <input type="email" name="email" id="email" ><br>
        Mensaje: <input type="text" name="mensaje" id="mensaje" ><br><br>
        Numero de Comensales: <input type="number" name="num" id="num" min="1" max="8"><br><br>
        Menú: <input type="number" name="menu" id="menu" min="1" max="3" ><br><br>
        <input type="text" name="fecha" id="fecha" value="{{$fecha}}" hidden>
        <input type="text" name="hora" id="hora" value="{{$hora}}" hidden>
        
        <b>Fecha: 
            @isset($fecha)
                {{$fecha}}
            @endisset
            <br>Hora:
            @isset($hora)
                {{$hora}}
            @endisset
        </b>
        <br><br>
            <input type="submit" value="Confirmar Reserva" id="enviar">
     </form><br>
     {{-- <img src="{{asset('media/spinner.webp')}}" id="spinner" style="visibility:hidden"> --}}
     <script src="{{ asset('js/eventos.js') }}"></script>
    </body>
</html>