<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('pessoas_fisicas_habilidades', function (Blueprint $table) {
            $table->unsignedBigInteger('id_pessoasFisicas');
            $table->unsignedBigInteger('id_habilidades');
            $table->primary(['id_pessoasFisicas', 'id_habilidades']);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('id_pessoasFisicas')
                ->references('id_pessoas')
                ->on('pessoas_fisicas')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('id_habilidades')
                ->references('id_habilidades')
                ->on('habilidades')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pessoas_fisicas_habilidades');
    }
};
