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
        Schema::create('favoritos', function (Blueprint $table) {

            $table->foreignId('id_pessoas')->constrained('pessoas_fisicas', 'id_pessoas')->cascadeOnDelete();

            $table->foreignId('id_vagas')->constrained('vagas', 'id_vagas')->cascadeOnDelete();

            $table->primary(['id_pessoas', 'id_vagas']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('favoritos');
    }
};
