<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('habilidades', function (Blueprint $table) {
            $table->id('id_habilidades');
            $table->string('nome', 255);
            $table->string('status', 45)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('habilidades');
    }
};
