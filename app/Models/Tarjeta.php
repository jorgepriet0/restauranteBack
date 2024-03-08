<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarjeta extends Model
{
    use HasFactory;
    protected $table = 'tarjeta';
    //pk
    protected $primaryKey ='id' ;

    protected $fillable = ['nombre','numero','cvv','fecha_caducidad'];

    public function user()  {
        return $this->belongsTo(User::class);
    }
}
