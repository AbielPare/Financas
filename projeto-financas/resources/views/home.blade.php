<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Badanha Finance - Home</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-[#121829] text-white font-sans min-h-screen flex flex-col justify-between">

    <main class="p-6 max-w-md mx-auto w-full flex-grow">
        
        <div class="mb-6">
            <h1 class="text-2xl font-bold">Olá, Bem-vindo!</h1>
            <p class="text-gray-400 text-sm">Resumo financeiro de hoje</p>
        </div>

        <div class="bg-[#1b233d] rounded-2xl p-6 mb-6 border border-gray-800 shadow-lg">
            <p class="text-gray-400 text-xs uppercase tracking-wider mb-1">Saldo Geral Disponível</p>
            <h2 class="text-3xl font-black text-blue-500">R$ {{ number_format($saldoGeral, 2, ',', '.') }}</h2>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-6">
            <div class="bg-[#1b233d] rounded-xl p-4 border border-gray-800">
                <span class="text-xs text-gray-400 block mb-1">Ganhos ({{ ucfirst($nomeMes) }})</span>
                <span class="text-lg font-bold text-green-400">+ R$ {{ number_format($renda, 2, ',', '.') }}</span>
            </div>
            <div class="bg-[#1b233d] rounded-xl p-4 border border-gray-800">
                <span class="text-xs text-gray-400 block mb-1">Gastos ({{ ucfirst($nomeMes) }})</span>
                <span class="text-lg font-bold text-red-400">- R$ {{ number_format($gastos, 2, ',', '.') }}</span>
            </div>
        </div>

        <div>
            <h3 class="text-sm font-semibold text-gray-400 mb-3">Últimas Atividades</h3>
            <div class="space-y-3">
                @forelse($ultimasTransacoes as $transacao)
                    <div class="bg-[#1b233d] flex justify-between items-center p-3 rounded-xl border border-gray-800">
                        <div>
                            <p class="text-sm font-medium">{{ $transacao->description }}</p>
                            <span class="text-xs text-gray-500">{{ $transacao->category }}</span>
                        </div>
                        <span class="text-sm font-bold {{ $transacao->type == 'income' ? 'text-green-400' : 'text-red-400' }}">
                            {{ $transacao->type == 'income' ? '+' : '-' }} R$ {{ number_format($transacao->amount, 2, ',', '.') }}
                        </span>
                    </div>
                @empty
                    <p class="text-gray-500 text-sm text-center py-4">Nenhuma movimentação encontrada.</p>
                @endforelse
            </div>
        </div>

        <div class="fixed bottom-24 right-6 z-50">
            <a href="/transacao/criar" class="bg-blue-500 hover:bg-blue-600 w-14 h-14 rounded-full flex items-center justify-center text-2xl font-bold shadow-2xl transition transform hover:scale-110 active:scale-95">
                +
            </a>
        </div>

    </main>

    <footer class="bg-[#0f1422] border-t border-gray-850 p-4 sticky bottom-0">
        <div class="max-w-md mx-auto flex justify-between items-center text-center text-xs text-gray-400">
            <a href="/home" class="flex flex-col items-center text-blue-500 font-semibold">
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
            <a href="/comparacao" class="flex flex-col items-center hover:text-white transition">
                <span class="text-lg">🗓️</span>
                <span>Comparação</span>
            </a>
            
            <form action="/logout" method="POST" class="inline m-0 p-0">
                @csrf
                <button type="submit" class="flex flex-col items-center hover:text-red-400 transition text-gray-400 text-xs bg-transparent border-0 cursor-pointer p-0 m-0">
                    <span class="text-lg">🚪</span>
                    <span>Sair</span>
                </button>
            </form>
        </div>
    </footer>

</body>
</html>