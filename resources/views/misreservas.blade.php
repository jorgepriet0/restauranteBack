<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mis Reservas') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if ($reservas)
    @foreach ($reservas as $reserva)
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <p>Fecha: {{ $reserva->fecha }}</p>
                <p>Hora: {{ $reserva->hora }}</p>
                <p>Número de Comensales: {{ $reserva->num_comensales }}</p>
                <form action="{{route('cancelarReserva')}}" method="POST">
                    @csrf
                    @method('delete')
                    <button type="submit" style="background-color: rgb(85, 82, 82); color:rgb(212, 212, 212); padding:3px;">Cancelar</button>
                    <input type="hidden" name="id" value="{{$reserva->id}}">

                </form>
            </div>
        </div>
    @endforeach
@else
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            No hay reservas disponibles
        </div>
@endif
            
        </div>
    </div>
</x-app-layout>

