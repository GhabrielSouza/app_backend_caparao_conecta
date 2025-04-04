<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('candidaturas', function (Blueprint $table) {
            $table->unsignedBigInteger('id_vagas');
            $table->unsignedBigInteger('id_pessoasFisicas');
            $table->date('data_candidatura');
            $table->primary(['id_vagas', 'id_pessoasFisicas']);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_vagas')
                ->references('id_vagas')
                ->on('vagas')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('id_pessoasFisicas')
                ->references('id_pessoas')
                ->on('pessoas_fisicas')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('candidaturas');
    }
};
