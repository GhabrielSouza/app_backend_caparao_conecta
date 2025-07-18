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
            $table->primary(['id_vagas', 'id_pessoasFisicas']);
            $table->string('status')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_vagas')
                ->references('id_vagas')
                ->on('vagas');


            $table->foreign('id_pessoasFisicas')
                ->references('id_pessoas')
                ->on('pessoas_fisicas');

        });
    }

    public function down()
    {
        Schema::dropIfExists('candidaturas');
    }
};
