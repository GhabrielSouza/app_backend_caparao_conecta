<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->string('email', 255);
            $table->string('senha', 512);
            $table->foreignId('id_tipo_usuarios')->constrained('tipo_usuarios', 'id_tipo_usuarios')->onDelete('cascade');
            $table->unsignedBigInteger('id_pessoas')->primary();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_pessoas')
                ->references('id_pessoas')
                ->on('pessoas')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('usuarios');
    }
};
