<?php
namespace Database\Seeders;
use Carbon\Carbon;
use App\Models\Horario;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;



class HorarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $fechas = [
            '2024-01-02', '2024-02-02', '2024-02-03', '2024-02-04', '2024-02-05',
            '2024-02-08', '2024-02-09', '2024-02-10', '2024-02-11', '2024-02-12',
        ];

        $horas = [
            '13:00h', '13:15h', '13:30h', '13:45h', '14:00h',
            '14:15h', '14:30h', '20:00h', '20:15h', '20:30h',
        ];

        $fechahora = [];
        for ($i = 0; $i < 20; $i++) {
            // Fecha y hora aleatoria
            $fecha = $fechas[array_rand($fechas)];
            $hora = $horas[array_rand($horas)];

            $total = $fecha . ' ' . $hora;

            if (!in_array($total, $fechahora)) {
                DB::table('horario')->insert([
                    'fecha' => $fecha,
                    'hora' => $hora,
                    'disponible' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $fechahora[] = $total; 
            }
            
    }
}

}