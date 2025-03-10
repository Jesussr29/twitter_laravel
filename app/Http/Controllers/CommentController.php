<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, $publicacionId)
    {
        $request->validate([
            'content' => 'required|max:500',
        ]);

        Comment::create([
            'user_id' => Auth::id(),
            'publicacion_id' => $publicacionId,
            'content' => $request->content,
        ]);

        return redirect()->route('publicacion.index');
    }

    public function edit($id)
    {
        $comment = Comment::findOrFail($id);
        if ($comment->user_id != Auth::id()) {
            return redirect()->route('publicacion.index');
        }

        return view('twitter.editComment', compact('comment'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|max:500',
        ]);

        $comment = Comment::findOrFail($id);
        if ($comment->user_id == Auth::id()) {
            $comment->update($request->all());
        }

        return redirect()->route('publicacion.index');
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        if ($comment->user_id == Auth::id()) {
            $comment->delete();
        }

        return redirect()->route('publicacion.index');
    }
}