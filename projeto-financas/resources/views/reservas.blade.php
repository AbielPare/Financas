<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Badanha Finance - Minhas Reservas</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-[#121829] text-white font-sans min-h-screen flex flex-col justify-between">

    <main class="p-6 max-w-md mx-auto w-full flex-grow">
        
        <div class="mb-6 text-center">
            <h1 class="text-xl font-bold">Minha Reserva Total:</h1>
            <h2 class="text-3xl font-black text-blue-500 mt-1">R$ {{ number_format($reservaTotal, 2, ',', '.') }}</h2>
        </div>

        <div class="mb-6 text-center">
            <a href="/reservas/depositar" class="inline-block bg-blue-500 hover:bg-blue-600 text-sm font-bold py-2 px-6 rounded-xl transition shadow-lg">
                + Guardar Dinheiro
            </a>
        </div>

        <div class="space-y-6">
            @forelse($metas as $meta)
                @php
                    // Cálculo da porcentagem (evitando divisão por zero)
                    $porcentagem = $meta->target_amount > 0 ? ($meta->current_amount / $meta->target_amount) * 100 : 0;
                    // Limitando a exibição para no máximo 100% se passar do objetivo
                    $porcentagemBarra = min($porcentagem, 100);
                @endphp

                <div class="bg-[#1b233d] rounded-2xl p-4 border border-gray-800 shadow-lg relative">
                    
                    <div class="flex gap-4 items-center mb-4">
                        <img src="{{ $meta->image_url }}" alt="{{ $meta->name }}" class="w-20 h-20 object-cover rounded-xl border border-gray-700">
                        
                        <div class="flex-grow">
                            <h3 class="text-lg font-bold">{{ $meta->name }}</h3>
                            <div class="mt-1 text-sm space-y-0.5">
                                <p class="text-gray-400 flex justify-between">Preço: <span class="text-white font-semibold">R$ {{ number_format($meta->target_amount, 2, ',', '.') }}</span></p>
                                <p class="text-gray-400 flex justify-between">Guardado: <span class="text-blue-400 font-semibold">R$ {{ number_format($meta->current_amount, 2, ',', '.') }}</span></p>
                            </div>
                        </div>
                    </div>

                    <div class="w-full bg-[#121829] h-6 rounded-full overflow-hidden border border-gray-800 relative">
                        <div class="bg-blue-500 h-full flex items-center justify-center transition-all duration-500 text-xs font-bold shadow-inner" style="width: {{ $porcentagemBarra }}%">
                            {{ round($porcentagem) }}%
                        </div>
                    </div>

                </div>
            @empty
                <p class="text-gray-500 text-sm text-center py-8">Você ainda não definiu nenhuma meta.</p>
            @endforelse
        </div>

        <!-- botão para adicionar meta -->
        <div class="fixed bottom-24 right-6 z-50">
            <a href="/reservas/criar" class="bg-blue-500 hover:bg-blue-600 w-14 h-14 rounded-full flex items-center justify-center text-2xl font-bold shadow-2xl transition transform hover:scale-110 active:scale-95">
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
            <a href="/reservas" class="flex flex-col items-center text-blue-500 font-semibold">
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
        </div>
    </footer>

</body>
</html>