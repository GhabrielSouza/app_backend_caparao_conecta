<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('cidades', function (Blueprint $table) {
            $table->id('id_cidades');
            $table->string('nome_cidade', 50);
            $table->foreignId('id_pais')->constrained('pais', 'id_pais')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cidades');
    }
};
