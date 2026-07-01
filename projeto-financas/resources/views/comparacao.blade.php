<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Badanha Finance - Comparação</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-[#121829] text-white font-sans min-h-screen flex flex-col justify-between">

    <main class="p-6 max-w-md mx-auto w-full flex-grow">
        
        <div class="mb-6 flex justify-between items-center">
            <h1 class="text-xl font-bold">Distribuição de Gastos</h1>
            
            <form action="/comparacao" method="GET" id="filterForm">
                <select name="periodo" onchange="document.getElementById('filterForm').submit()" class="bg-[#1b233d] text-sm text-white rounded-xl p-2 border border-gray-800 cursor-pointer focus:outline-none">
                    @foreach($mesesDisponiveis as $value => $label)
                        <option value="{{ $value }}" {{ $periodo == $value ? 'selected' : '' }}>
                            {{ ucfirst($label) }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>

        <p class="text-gray-400 text-sm mb-4 text-center">Gastos Totais: <span class="text-red-400 font-bold">R$ {{ number_format($gastosTotais, 2, ',', '.') }}</span></p>

        <div class="bg-[#1b233d] rounded-2xl p-6 mb-6 border border-gray-800 shadow-lg flex justify-center">
            <div class="h-64 w-64">
                <canvas id="donutChart"></canvas>
            </div>
        </div>

        <div class="bg-[#1b233d] rounded-2xl p-4 border border-gray-800 shadow-lg space-y-3">
            @forelse($gastosPorCategoria as $gasto)
                <div class="flex justify-between items-center p-2 border-b border-gray-800 last:border-0">
                    <span class="font-medium text-sm">{{ $gasto->category }}</span>
                    <span class="font-bold text-sm text-red-400">R$ {{ number_format($gasto->total, 2, ',', '.') }}</span>
                </div>
            @empty
                <p class="text-gray-500 text-sm text-center py-4">Nenhum gasto registrado neste mês.</p>
            @endforelse
        </div>

        <div class="fixed bottom-24 right-6 z-50">
            <a href="/transacao/criar" class="bg-blue-500 hover:bg-blue-600 w-14 h-14 rounded-full flex items-center justify-center text-2xl font-bold shadow-2xl transition transform hover:scale-110 active:scale-95">
                +
            </a>
        </div>

    </main>

    <footer class="bg-[#0f1422] border-t border-gray-850 p-4 sticky bottom-0">
        <div class="max-w-md mx-auto flex justify-between text-center text-xs text-gray-400">
            <a href="/home" class="flex flex-col items-center hover:text-white transition">
                <span class="text-lg">🏠</span>
                <span>Home</span>
            </a>
            <a href="/reservas" class="flex flex-col items-center hover:text-white transition">
                <span class="text-lg">🏦</span>
                <span>Reservas</span>
            </a>
            <a href="/mensal" class="flex flex-col items-center hover:text-white transition">
                <span class="text-lg">📊</span>
                <span>Mensal</span>
            </a>
            <a href="/comparacao" class="flex flex-col items-center text-blue-500 font-semibold">
                <span class="text-lg">🗓️</span>
                <span>Comparação</span>
            </a>
        </div>
    </footer>

    <script>
        const ctx = document.getElementById('donutChart').getContext('2d');
        
        // Cores vibrantes para as categorias, batendo com o tema escuro
        const cores = ['#f87171', '#fb923c', '#4ade80', '#60a5fa', '#c084fc', '#f472b6'];

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                // Passando as categorias vindas do banco como labels do gráfico
                labels: {!! json_encode($gastosPorCategoria->pluck('category')) !!},
                datasets: [{
                    data: {!! json_encode($gastosPorCategoria->pluck('total')) !!},
                    backgroundColor: cores,
                    borderWidth: 0,
                    weight: 0.5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { color: '#94a3b8', font: { size: 11 } }
                    }
                },
                cutout: '70%' // Deixa o meio mais aberto, estilo "rosca" fina e moderna
            }
        });
    </script>
</body>
</html>