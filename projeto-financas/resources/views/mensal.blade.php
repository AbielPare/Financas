<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Badanha Finance - Relatório Mensal</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-[#121829] text-white font-sans min-h-screen flex flex-col justify-between">

    <main class="p-6 max-w-md mx-auto w-full flex-grow">
        
        <div class="mb-6 flex justify-between items-center">
            <h1 class="text-xl font-bold">Relatório Mensal</h1>
            
            <form action="/mensal" method="GET" id="filterForm">
                <select name="periodo" onchange="document.getElementById('filterForm').submit()" class="bg-[#1b233d] text-sm text-white rounded-xl p-2 border border-gray-800 cursor-pointer focus:outline-none">
                    @foreach($mesesDisponiveis as $value => $label)
                        <option value="{{ $value }}" {{ $periodo == $value ? 'selected' : '' }}>
                            {{ ucfirst($label) }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>

        <div class="bg-[#1b233d] rounded-2xl p-4 mb-6 border border-gray-800 shadow-lg">
            <p class="text-center text-xs text-gray-400 uppercase tracking-wider mb-4 font-semibold">Renda x Gastos</p>
            <div class="h-64 flex justify-center">
                <canvas id="myChart"></canvas>
            </div>
        </div>

        <div class="bg-[#1b233d] rounded-2xl p-6 text-center border border-gray-800 shadow-lg">
            <p class="text-gray-400 text-sm mb-2">Total economizado nesse mês:</p>
            <h2 class="text-2xl font-black {{ $totalEconomizado >= 0 ? 'text-green-400' : 'text-red-400' }}">
                R$ {{ number_format($totalEconomizado, 2, ',', '.') }}
            </h2>
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
            <a href="/mensal" class="flex flex-col items-center text-blue-500 font-semibold">
                <span class="text-lg">📊</span>
                <span>Mensal</span>
            </a>
            <a href="comparacao" class="flex flex-col items-center hover:text-white transition">
                <span class="text-lg">🗓️</span>
                <span>Comparação</span>
            </a>
        </div>
    </footer>

    <script>
        const ctx = document.getElementById('myChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Renda', 'Gastos'],
                datasets: [{
                    data: [{{ $renda }}, {{ $gastos }}],
                    backgroundColor: ['#60a5fa', '#f87171'], // Azul e Vermelho combinando com o layout
                    borderRadius: 8,
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false } // Esconder legenda para ficar limpo
                },
                scales: {
                    y: {
                        grid: { color: '#1e293b' },
                        ticks: { color: '#94a3b8' }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { color: '#94a3b8' }
                    }
                }
            }
        });
    </script>
</body>
</html>