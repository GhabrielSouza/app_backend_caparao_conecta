<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('pessoas_fisicas', function (Blueprint $table) {
            $table->unsignedBigInteger('id_pessoas')->primary();
            $table->string('cpf', 11)->unique();
            $table->date('data_de_nascimento');
            $table->string('sobrenome', 255);
            $table->string('cad_unico', 12)->nullable()->unique();
            $table->string('genero', 45);
            $table->softDeletes();

            $table->foreign('id_pessoas')
                ->references('id_pessoas')
                ->on('pessoas');

        });
    }

    public function down()
    {
        Schema::dropIfExists('pessoas_fisicas');
    }
};
