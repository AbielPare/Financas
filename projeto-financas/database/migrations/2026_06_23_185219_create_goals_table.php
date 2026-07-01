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
    Schema::create('goals', function (Blueprint $table) {
        $table->id();
        $table->string('name'); // Ex: "Novo Notebook", "Férias"
        $table->decimal('target_amount', 10, 2); // Preço total da meta (ex: 3000.00)
        $table->decimal('current_amount', 10, 2)->default(0.00); // Quanto você já guardou (ex: 500.00)
        $table->string('image_url')->nullable(); // Para guardarmos o link de uma foto da meta
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('goals');
    }
};
