<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void
{
    Schema::create('comentarios', function (Blueprint $table) {
        $table->id();

       $table->unsignedBigInteger('noticia_id');
       $table->foreign('noticia_id')->references('id')->on('noticias')->onDelete('cascade');

        //Mensaje
        $table->text('mensaje');

        //Valoración positiva o negativa
        $table->enum('valoracion', ['pos', 'neg']);

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comentarios');
    }
};