<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('vagas', function (Blueprint $table) {
            $table->id('id_vagas');
            $table->string('titulo_vaga', 255);
            $table->string('descricao')->nullable();
            $table->decimal('salario', 9, 2);
            $table->string('status', 255)->nullable();

            $table->date('data_criacao');
            $table->date('data_fechamento');
            $table->integer('qtd_vaga');
            $table->boolean('prorrogavel')->default(true);
            $table->integer('qtd_vagas_preenchidas')->nullable();
            $table->integer('visualizacoes')->default(0);
            $table->string('modalidade_da_vaga', 255);
            $table->foreignId('id_empresas')->constrained('empresas', 'id_pessoas');

            $table->foreignId('id_areas_atuacao')->nullable()->constrained('areas_atuacao', 'id_areas_atuacao');

            $table->timestamps();
            $table->softDeletes();

        });
    }

    public function down()
    {
        Schema::dropIfExists('vagas');
    }
};
