<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('vagas_cursos', function (Blueprint $table) {
            $table->unsignedBigInteger('id_cursos');
            $table->unsignedBigInteger('id_vagas');
            $table->primary(['id_cursos', 'id_vagas']);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_cursos')
                ->references('id_cursos')
                ->on('cursos')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('id_vagas')
                ->references('id_vagas')
                ->on('vagas')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('vagas_cursos');
    }
};
