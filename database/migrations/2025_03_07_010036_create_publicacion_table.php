<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePublicacionTable extends Migration
{
    public function up()
    {
        Schema::create('publicacion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_usuario')->constrained('users')->onDelete('cascade');
            $table->text('contenido');
            $table->integer('likes')->default(0);
            $table->integer('retweet')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('publicacion');
    }
}