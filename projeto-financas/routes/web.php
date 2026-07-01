<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReportController;
use App\Models\Goal;
use App\Http\Controllers\TransactionController;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Http\Controllers\AuthController;

// --- ROTAS PÚBLICAS (Qualquer um acessa) ---
Route::get('/', function () {
    return redirect('/home');
});
// 2. A rota /home DEVE chamar o método 'index' do seu HomeController
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->middleware('auth');

// Rotas de Cadastro
Route::get('/cadastro', [AuthController::class, 'showCadastro']);
Route::post('/cadastro', [AuthController::class, 'register']);

// Rotas de Login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);


// --- ROTAS PROTEGIDAS (Só entra quem estiver logado) ---
Route::middleware(['auth'])->group(function () {

    // --- HOME E RELATÓRIOS (As rotas que tinham sumido!) ---
    Route::get('/home', [HomeController::class, 'index']);
    Route::get('/mensal', [ReportController::class, 'mensal']);
    Route::get('/comparacao', [ReportController::class, 'comparacao']);

    // --- GERENCIAMENTO DE RESERVAS / METAS ---
    // Listar apenas as Reservas/Metas do usuário logado
    Route::get('/reservas', function () {
        $user = auth()->user();
        $metas = $user->goals;
        $reservaTotal = $user->goals()->sum('current_amount');
        return view('reservas', compact('metas', 'reservaTotal'));
    });

    // 🌟 ADICIONE ESSA ROTA AQUI (A que estava faltando!):
    Route::get('/reservas/criar', function () {
        return view('create_goal'); // Garanta que o nome do seu arquivo blade de criar meta seja esse
    });

    // Formulário de depósito mostrando apenas as metas dele
    Route::get('/reservas/depositar', function () {
        $metas = auth()->user()->goals;
        return view('deposit_goal', compact('metas'));
    });

    // Processar o depósito na meta dele e gerar a transação com user_id
    Route::post('/reservas/salvar-deposito', function (Request $request) {
        $request->validate([
            'goal_id' => 'required|exists:goals,id',
            'amount' => 'required|numeric|min:0.01',
        ]);

        // Garante que o usuário só consiga depositar em uma meta que realmente pertença a ele
        $meta = auth()->user()->goals()->findOrFail($request->goal_id);
        $valor = $request->amount;

        $meta->current_amount += $valor;
        $meta->save();

        // Cria a transação de despesa atrelada ao usuário logado
        Transaction::create([
            'description' => "Reserva: {$meta->name}",
            'amount' => $valor,
            'type' => 'expense',
            'category' => 'Reservas',
            'date' => date('Y-m-d'),
            'user_id' => auth()->id(), // Vincula a transação ao usuário
        ]);

        return redirect('/reservas')->with('success', 'Dinheiro guardado com sucesso!');
    });

    // Salvar uma nova meta vinculada ao usuário logado
    Route::post('/reservas/salvar-meta', function (Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'target_amount' => 'required|numeric|min:0.01',
            'current_amount' => 'nullable|numeric|min:0',
            'image_url' => 'nullable|url',
        ]);

        $imageUrl = $request->image_url ?? 'https://images.unsplash.com/photo-1579621970563-ebec7560ff3e?w=500';

        // Cria a meta direto a partir do relacionamento do usuário
        auth()->user()->goals()->create([
            'name' => $request->name,
            'target_amount' => $request->target_amount,
            'current_amount' => $request->current_amount ?? 0.00,
            'image_url' => $imageUrl,
        ]);

        return redirect('/reservas')->with('success', 'Nova meta criada com sucesso!');
    });

    // Criar Transações (Ganhos/Gastos)
    Route::get('/transacao/criar', [TransactionController::class, 'create']);
    Route::post('/transacao/salvar', [TransactionController::class, 'store']);

    // Rota de Logout
    Route::post('/logout', [AuthController::class, 'logout']);

});