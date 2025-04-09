<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('formacoes_academicas', function (Blueprint $table) {
            $table->id('id_formacoes_academicas');
            $table->string('escolaridade', 255);
            $table->string('area_de_estudo', 255)->nullable();
            $table->boolean('diploma_formacao');
            $table->boolean('conclusao_formacao');
            $table->date('data_emissao');
            $table->date('data_conclusao');
            $table->unsignedBigInteger('id_pessoasFisicas');
            $table->foreignId('id_instituicoes')->constrained('instituicoes', 'id_instituicoes')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_pessoasFisicas')
                ->references('id_pessoas')
                ->on('pessoas_fisicas');

        });
    }

    public function down()
    {
        Schema::dropIfExists('formacoes_academicas');
    }
};
