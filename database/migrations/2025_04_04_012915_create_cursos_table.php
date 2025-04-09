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
            $table->string('organizacao_emissora', 255);
            $table->string('cargo_horaria', 50);
            $table->boolean('certificado_curso');
            $table->date('data_conclusao');
            $table->string('tipo_de_curso', 255)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cursos');
    }
};
