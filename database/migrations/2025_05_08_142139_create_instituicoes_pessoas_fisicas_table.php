<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('instituicoes_pessoas_fisicas', function (Blueprint $table) {
            $table->unsignedBigInteger('id_instituicoes');
            $table->unsignedBigInteger('id_pessoasFisicas');
            $table->primary(['id_instituicoes', 'id_pessoasFisicas']);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_instituicoes')
                ->references('id_instituicoes')
                ->on('instituicoes');


            $table->foreign('id_pessoasFisicas')
                ->references('id_pessoas')
                ->on('pessoas_fisicas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instituicoes_pessoas_fisicas');
    }
};
