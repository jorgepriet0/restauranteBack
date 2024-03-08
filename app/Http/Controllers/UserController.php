<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    function index(){
        $usuarios = User::all();
        dd($usuarios[0]->email);
    }
}
