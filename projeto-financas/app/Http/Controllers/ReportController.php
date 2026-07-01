<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function mensal(Request $request)
    {
        $user = auth()->user();

        // Alinhado com a View
        $periodo = $request->input('periodo', Carbon::now()->format('Y-m'));
        $data = Carbon::createFromFormat('Y-m', $periodo);

        $renda = $user->transactions()
            ->where('type', 'income')
            ->whereMonth('date', $data->month)
            ->whereYear('date', $data->year)
            ->sum('amount');

        $gastos = $user->transactions()
            ->where('type', 'expense')
            ->whereMonth('date', $data->month)
            ->whereYear('date', $data->year)
            ->sum('amount');

        // Batendo exatamente com a sua linha 37: $totalEconomizado
        $totalEconomizado = $renda - $gastos;

        $mesesDisponiveis = [];
        for ($i = 0; $i < 6; $i++) {
            $carbonMes = Carbon::now()->subMonths($i);
            $value = $carbonMes->format('Y-m');
            $label = $carbonMes->translatedFormat('F / Y');
            $mesesDisponiveis[$value] = $label;
        }

        return view('mensal', compact('renda', 'gastos', 'totalEconomizado', 'mesesDisponiveis', 'periodo'));
    }

    public function comparacao(Request $request)
    {
        $user = auth()->user();

        $periodo = $request->input('periodo', Carbon::now()->format('Y-m'));
        $data = Carbon::createFromFormat('Y-m', $periodo);

        $gastosPorCategoria = $user->transactions()
            ->where('type', 'expense')
            ->whereMonth('date', $data->month)
            ->whereYear('date', $data->year)
            ->selectRaw('category, sum(amount) as total')
            ->groupBy('category')
            ->get();

        $gastosTotais = $gastosPorCategoria->sum('total');

        $mesesDisponiveis = [];
        for ($i = 0; $i < 6; $i++) {
            $carbonMes = Carbon::now()->subMonths($i);
            $value = $carbonMes->format('Y-m');
            $label = $carbonMes->translatedFormat('F / Y');
            $mesesDisponiveis[$value] = $label;
        }

        return view('comparacao', compact('gastosPorCategoria', 'gastosTotais', 'mesesDisponiveis', 'periodo'));
    }
}