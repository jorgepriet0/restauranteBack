<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurante - Reservar Mesa</title>
</head>

<body>
  <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Reservar') }}
        </h2>
        <div id='calendar'></div>
    </x-slot>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js'></script>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
          initialView: 'dayGridMonth',
          //Array de los eventos con las horas disponibles
          events:@json($eventos), 
        });
        calendar.render();
      });
    </script>
    @vite(['resources/js/app.js'])
  </x-app-layout>
</body>
</html>