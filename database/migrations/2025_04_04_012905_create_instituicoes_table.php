<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('instituicoes', function (Blueprint $table) {
            $table->id('id_instituicoes');
            $table->string('nome', 45);
            $table->foreignId('id_cidades')->constrained('cidades', 'id_cidades')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('instituicoes');
    }
};
