<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Publicacion;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function profile()
    {
        $usuario = Auth::user();
        $publicaciones = Publicacion::where('id_usuario', $usuario->id)->orderBy('created_at', 'desc')->get();

        return view('twitter.profile', compact('usuario', 'publicaciones'));
    }
}