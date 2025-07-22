<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('pessoas_fisicas', function (Blueprint $table) {
            $table->foreignId('id_pessoas')->primary()->constrained('pessoas', 'id_pessoas');

            $table->string('cpf', 20)->unique();
            $table->date('data_de_nascimento');
            $table->string('sobrenome', 255);
            $table->string('cad_unico', 12)->nullable()->unique();
            $table->string('genero', 45);

            $table->foreignId('id_areas_atuacao')->nullable()->constrained('areas_atuacao', 'id_areas_atuacao');

            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pessoas_fisicas');
    }
};
