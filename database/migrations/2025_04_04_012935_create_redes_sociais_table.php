<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('redes_sociais', function (Blueprint $table) {
            $table->string('instagram', 255)->nullable();
            $table->string('github', 255)->nullable();
            $table->string('linkedin', 255)->nullable();
            $table->string('curriculo_lattes', 255)->nullable();
            $table->id('id_redeSociais');
            $table->unsignedBigInteger('id_pessoas');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_pessoas')
                ->references('id_pessoas')
                ->on('pessoas')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('redes_sociais');
    }
};
