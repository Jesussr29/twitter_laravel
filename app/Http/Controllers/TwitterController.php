<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Publicacion;
use Illuminate\Support\Facades\Auth;

class TwitterController extends Controller
{
    public function index()
    {
        $publicaciones = Publicacion::orderBy('created_at', 'desc')->get();
        return view('twitter.index', compact('publicaciones'));
    }

    public function obtenerTodas()
    {
        return response()->json(Publicacion::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'contenido' => 'required|max:500',
        ]);

        Publicacion::create([
            'id_usuario' => Auth::id(),
            'contenido' => $request->contenido,
            'likes' => 0,
            'retweet' => 0,
        ]);

        return redirect()->route('publicacion.index');
    }

    public function edit($id)
    {
        $publicacion = Publicacion::findOrFail($id);
        return view('twitter.edit', compact('publicacion'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'contenido' => 'required|max:500',
        ]);

        $publicacion = Publicacion::findOrFail($id);
        $publicacion->update($request->all());

        return redirect()->route('publicacion.index');
    }

    public function destroy($id)
    {
        $publicacion = Publicacion::findOrFail($id);
        $publicacion->delete();

        return redirect()->route('publicacion.index');
    }

    public function like($id)
    {
        $publicacion = Publicacion::findOrFail($id);
        if ($publicacion->likes()->where('user_id', Auth::id())->exists()) {
            $publicacion->likes()->detach(Auth::id());
            $publicacion->decrement('likes');
        } else {
            $publicacion->likes()->attach(Auth::id());
            $publicacion->increment('likes');
        }

        return response()->json(['likes' => $publicacion->likes]);
    }

    public function retweet($id)
    {
        $publicacion = Publicacion::findOrFail($id);
        if ($publicacion->retweets()->where('user_id', Auth::id())->exists()) {
            $publicacion->retweets()->detach(Auth::id());
            $publicacion->decrement('retweet');
        } else {
            $publicacion->retweets()->attach(Auth::id());
            $publicacion->increment('retweet');
        }

        return response()->json(['retweets' => $publicacion->retweet]);
    }
}