<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('areas_atuacao', function (Blueprint $table) {

            $table->id('id_areas_atuacao');

            $table->string('nome_area')->unique();

            $table->string('status')->default('Pendente');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('areas_atuacao');
    }
};
