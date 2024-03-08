<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Reservar extends Controller
{
   function index(){
        return view("reservar");
    }
}
