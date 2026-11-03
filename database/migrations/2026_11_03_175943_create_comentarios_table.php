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

        //Noticia a la que pertenece
        $table->foreignId('noticia_id')
              ->constrained('noticias');

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
