<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('experiencias', function (Blueprint $table) {
            $table->id('id_experiencias');
            $table->string('cargo', 255);
            $table->string('nome_empresa', 255);
            $table->boolean('comprovacao');
            $table->text('descricao')->nullable();
            $table->unsignedBigInteger('id_pessoasFisicas');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_pessoasFisicas')
                ->references('id_pessoas')
                ->on('pessoas_fisicas');

        });
    }

    public function down()
    {
        Schema::dropIfExists('experiencias');
    }
};
