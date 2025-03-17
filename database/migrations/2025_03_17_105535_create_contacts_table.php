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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id(); // Cria a coluna id
            $table->string('name'); // Cria a coluna 'name'
            $table->string('phone'); // Cria a coluna 'phone'
            $table->string('email'); // Cria a coluna 'email'
            $table->text('observation')->nullable(); // Cria a coluna 'observation', permitindo valores nulos
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Cria a coluna 'user_id' e define a chave estrangeira
            $table->timestamps(); // Cria as colunas de timestamps (created_at e updated_at)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
