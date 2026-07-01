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
    Schema::create('transactions', function (Blueprint $table) {
        $table->id();
        $table->string('description'); // Ex: "Salário", "Mercado", "Cinema"
        $table->decimal('amount', 10, 2); // Para valores monetários (ex: 1500.50)
        $table->string('type'); // 'income' para Renda ou 'expense' para Gasto
        $table->string('category'); // Ex: Lazer, Alimentação, Transporte
        $table->date('date'); // A data em que aconteceu (essencial para o nosso filtro de meses!)
        $table->timestamps(); // Cria as colunas criada_em e atualizada_em automaticamente
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction');
    }
};
