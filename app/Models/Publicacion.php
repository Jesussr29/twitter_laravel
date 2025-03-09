<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publicacion extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_usuario',
        'contenido',
        'likes',
        'retweet',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

}