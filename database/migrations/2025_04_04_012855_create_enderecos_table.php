<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('enderecos', function (Blueprint $table) {
            $table->id('id_enderecos');
            $table->string('cep', 10);
            $table->foreignId('id_cidades')->constrained('cidades', 'id_cidades')->onDelete('cascade');
            $table->string('bairro', 255)->nullable();
            $table->string('endereco', 255)->nullable();
            $table->unsignedBigInteger('id_pessoas');
            $table->string('estado', 255);
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
        Schema::dropIfExists('enderecos');
    }
};
