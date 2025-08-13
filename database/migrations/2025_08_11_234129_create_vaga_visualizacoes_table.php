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
        Schema::create('vaga_visualizacoes', function (Blueprint $table) {

            $table->foreignId('id_vagas')->constrained('vagas', 'id_vagas')->cascadeOnDelete();

            $table->foreignId('id_pessoas')->constrained('pessoas_fisicas', 'id_pessoas')->cascadeOnDelete();

            $table->primary(['id_vagas', 'id_pessoas']);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vaga_visualizacoes');
    }
};
