<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        // Captura o usuário que está logado na sessão atual
        $user = auth()->user();

        $hoje = Carbon::now();
        $mesAtual = $hoje->month;
        $anoAtual = $hoje->year;
        $nomeMes = $hoje->translatedFormat('F');

        // 1. Somar APENAS as Rendas do usuário logado no mês atual
        $renda = $user->transactions()
            ->where('type', 'income')
            ->whereMonth('date', $mesAtual)
            ->whereYear('date', $anoAtual)
            ->sum('amount');

        // 2. Somar APENAS os Gastos do usuário logado no mês atual
        $gastos = $user->transactions()
            ->where('type', 'expense')
            ->whereMonth('date', $mesAtual)
            ->whereYear('date', $anoAtual)
            ->sum('amount');

        // 3. CORRIGIDO: Saldo Geral considera apenas transações até o dia de hoje
        $saldoGeral = $user->transactions()
            ->where('type', 'income')
            ->where('date', '<=', $hoje->format('Y-m-d'))
            ->sum('amount') 
            - 
            $user->transactions()
            ->where('type', 'expense')
            ->where('date', '<=', $hoje->format('Y-m-d'))
            ->sum('amount');

        // 4. CORRIGIDO: Pega as transações recentes DELE, mas apenas do mês atual
        $ultimasTransacoes = $user->transactions()
            ->whereMonth('date', $mesAtual)
            ->whereYear('date', $anoAtual)
            ->orderBy('date', 'desc')
            ->take(4)
            ->get();

        return view('home', compact('saldoGeral', 'renda', 'gastos', 'ultimasTransacoes', 'nomeMes'));
    }
}