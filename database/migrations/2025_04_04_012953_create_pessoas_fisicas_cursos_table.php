<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('pessoas_fisicas_cursos', function (Blueprint $table) {
            $table->unsignedBigInteger('id_cursos');
            $table->unsignedBigInteger('id_pessoasFisicas');
            $table->primary(['id_cursos', 'id_pessoasFisicas']);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_cursos')
                ->references('id_cursos')
                ->on('cursos');


            $table->foreign('id_pessoasFisicas')
                ->references('id_pessoas')
                ->on('pessoas_fisicas');

        });
    }

    public function down()
    {
        Schema::dropIfExists('pessoas_fisicas_cursos');
    }
};
