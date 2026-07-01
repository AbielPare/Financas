<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Badanha Finance - Guardar Dinheiro</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-[#121829] text-white font-sans min-h-screen flex flex-col justify-between">

    <main class="p-6 max-w-md mx-auto w-full flex-grow">
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-xl font-bold">Poupar para Meta</h1>
            <a href="/reservas" class="text-sm text-gray-400 hover:text-white">← Voltar</a>
        </div>

        <form action="/reservas/salvar-deposito" method="POST" class="space-y-4 bg-[#1b233d] p-6 rounded-2xl border border-gray-800 shadow-lg">
            @csrf 

            <div>
                <label class="block text-xs text-gray-400 uppercase font-semibold mb-1">Escolha o Objetivo</label>
                <select name="goal_id" required class="w-full bg-[#121829] border border-gray-800 rounded-xl p-3 text-sm text-white focus:outline-none focus:border-blue-500">
                    @foreach($metas as $meta)
                        <option value="{{ $meta->id }}">{{ $meta->name }} (Atual: R$ {{ number_format($meta->current_amount, 2, ',', '.') }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs text-gray-400 uppercase font-semibold mb-1">Valor a Guardar (R$)</label>
                <input type="number" step="0.01" name="amount" required placeholder="0.00" class="w-full bg-[#121829] border border-gray-800 rounded-xl p-3 text-sm text-white focus:outline-none focus:border-blue-500">
            </div>

            <button type="submit" class="w-full bg-green-500 hover:bg-green-600 font-bold p-3 rounded-xl transition mt-2 shadow-lg">
                Confirmar Depósito 
            </button>
        </form>
    </main>

</body>
</html>