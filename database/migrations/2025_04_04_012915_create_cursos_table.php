<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('cursos', function (Blueprint $table) {
            $table->id('id_cursos');
            $table->string('curso', 255);
            $table->string('cargo_horaria', 50);
            $table->string('link', 100)->nullable();
            $table->string('status', 45)->nullable();
            $table->foreignId('id_tipo_de_cursos')->constrained('tipo_de_cursos', 'id_tipo_de_cursos');
            $table->foreignId('id_instituicoes')->constrained('instituicoes', 'id_instituicoes')->onDelete('cascade');

            $table->timestamps();
            $table->softDeletes();

        });
    }

    public function down()
    {
        Schema::dropIfExists('cursos');
    }
};
