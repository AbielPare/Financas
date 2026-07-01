<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Goal;

class GoalSeeder extends Seeder
{
    public function run(): void
    {
        // Meta 1: Notebook
        Goal::create([
            'name' => 'Novo Notebook',
            'target_amount' => 3000.00,
            'current_amount' => 500.00,
            'image_url' => 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=500', // Imagem temporária de um macbook/notebook
        ]);

        // Meta 2: Férias
        Goal::create([
            'name' => 'Férias',
            'target_amount' => 3000.00,
            'current_amount' => 500.00,
            'image_url' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=500', // Imagem temporária de praia
        ]);
    }
}