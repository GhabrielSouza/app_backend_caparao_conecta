<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('vagas_habilidades', function (Blueprint $table) {
            $table->unsignedBigInteger('id_habilidades');
            $table->unsignedBigInteger('id_vagas');
            $table->primary(['id_habilidades', 'id_vagas']);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_habilidades')
                ->references('id_habilidades')
                ->on('habilidades')
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
        Schema::dropIfExists('vagas_habilidades');
    }
};
