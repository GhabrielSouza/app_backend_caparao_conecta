<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('pessoas', function (Blueprint $table) {
            $table->id('id_pessoas');
            $table->string('nome', 255);
            $table->string('telefone', 11);
            $table->text('sobre')->nullable();
            $table->string('imagem', 255)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pessoas');
    }
};
