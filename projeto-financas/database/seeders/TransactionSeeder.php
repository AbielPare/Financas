<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaction;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Criar uma Renda (Salário)
        Transaction::create([
            'description' => 'Salário Mensal',
            'amount' => 4000.00,
            'type' => 'income',
            'category' => 'Renda',
            'date' => '2026-06-05',
        ]);

        // 2. Criar um Gasto (Supermercado)
        Transaction::create([
            'description' => 'Compras do Mês',
            'amount' => 600.00,
            'type' => 'expense',
            'category' => 'Alimentação',
            'date' => '2026-06-10',
        ]);

        // 3. Criar outro Gasto (Combustível)
        Transaction::create([
            'description' => 'Posto de Combustível',
            'amount' => 200.00,
            'type' => 'expense',
            'category' => 'Transporte',
            'date' => '2526-06-15',
        ]);
        
        // 4. Criar um Freelance (Renda extra)
        Transaction::create([
            'description' => 'Desenho de Logótipo',
            'amount' => 500.00,
            'type' => 'income',
            'category' => 'Renda',
            'date' => '2026-06-18',
        ]);
    }
}