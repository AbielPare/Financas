<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            // Define se o gasto é fixo ou parcelado
            $table->boolean('is_recurring')->default(false);
            
            // Ex: 48 (total de parcelas)
            $table->integer('total_installments')->nullable();
            
            // Ex: 1, 2, 3 (a parcela atual)
            $table->integer('installment_number')->nullable();
            
            // Agrupador exclusivo para podermos deletar ou editar todas as parcelas juntas se necessário
            $table->string('recurrence_group')->nullable(); 
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn(['is_recurring', 'total_installments', 'installment_number', 'recurrence_group']);
        });
    }
};