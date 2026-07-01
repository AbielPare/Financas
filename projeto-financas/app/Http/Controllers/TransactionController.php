<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    // 1. Abre a tela do formulário
    public function create()
    {
        return view('create_transaction');
    }

    // 2. Recebe os dados e salva no banco
    public function store(Request $request)
{
    // 1. Validação dos dados recebidos do formulário
    $request->validate([
        'description' => 'required|string|max:255',
        'amount' => 'required|numeric|min:0.01',
        'type' => 'required|in:income,expense',
        'category' => 'required|string',
        'date' => 'required|date',
        'recurrence_type' => 'required|in:unique,fixed,installments',
        'installments' => 'nullable|integer|min:2',
    ]);

    $user = auth()->user();
    $recurrenceType = $request->recurrence_type;
    $dateOriginal = \Carbon\Carbon::parse($request->date);
    
    // ID único para agrupar todas as parcelas/recorrências filhas
    $recurrenceGroup = uniqid('rec_');

    // CASO 1: Transação Única (Normal)
    if ($recurrenceType === 'unique') {
        $user->transactions()->create([
            'description' => $request->description,
            'amount' => $request->amount,
            'type' => $request->type,
            'category' => $request->category,
            'date' => $request->date,
            'is_recurring' => false,
        ]);
    }
    
    // CASO 2: Parcelado (Ex: Carro em 48x)
    elseif ($recurrenceType === 'installments') {
        $totalInstallments = $request->installments;

        for ($i = 1; $i <= $totalInstallments; $i++) {
            // .copy() garante que estamos gerando uma nova data sem bagunçar a original
            $novaData = \Carbon\Carbon::parse($request->date)->addMonths($i - 1)->format('Y-m-d');

            $user->transactions()->create([
                'description' => $request->description . " ({$i}/{$totalInstallments})",
                'amount' => $request->amount,
                'type' => $request->type,
                'category' => $request->category,
                'date' => $novaData, // Usa a data corrigida avançando os meses
                'is_recurring' => true,
                'total_installments' => $totalInstallments,
                'installment_number' => $i,
                'recurrence_group' => $recurrenceGroup,
            ]);
        }
    }
    
    // CASO 3: Gasto/Ganho Fixo Mensal (Projeta 12 meses para frente)
    elseif ($recurrenceType === 'fixed') {
        for ($i = 1; $i <= 12; $i++) {
            // Avança rigorosamente 1 mês por repetição: 0 meses, 1 mês, 2 meses...
            $novaData = \Carbon\Carbon::parse($request->date)->addMonths($i - 1)->format('Y-m-d');

            $user->transactions()->create([
                'description' => $request->description . " (Fixo)",
                'amount' => $request->amount,
                'type' => $request->type,
                'category' => $request->category,
                'date' => $novaData, // Cada uma na sua respectiva folha do calendário
                'is_recurring' => true,
                'total_installments' => null,
                'installment_number' => $i,
                'recurrence_group' => $recurrenceGroup,
            ]);
        }
    }

    return redirect('/home')->with('success', 'Movimentação registrada com sucesso!');
    }
}