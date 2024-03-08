<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    use HasFactory;
    protected $table = 'reserva';
    //pk
    protected $primaryKey ='id' ;

    protected $fillable = ['fecha','hora','num_comensales','idHorario','idMenu','idUser','idTarjeta'];
}
