<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('empresas', function (Blueprint $table) {
            $table->string('cnpj', 20)->unique();
            $table->unsignedBigInteger('id_pessoas')->primary();
            $table->softDeletes();

            $table->foreign('id_pessoas')
                ->references('id_pessoas')
                ->on('pessoas');

        });
    }

    public function down()
    {
        Schema::dropIfExists('empresas');
    }
};
