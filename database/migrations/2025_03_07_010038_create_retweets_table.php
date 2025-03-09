<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRetweetsTable extends Migration
{
    public function up()
    {
        Schema::create('retweets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('publicacion_id')->constrained('publicacion')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('retweets');
    }
}