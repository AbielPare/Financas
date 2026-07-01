<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Badanha Finance - Nova Meta</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-[#121829] text-white font-sans min-h-screen flex flex-col justify-between">

    <main class="p-6 max-w-md mx-auto w-full flex-grow">
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-xl font-bold">Nova Meta de Reserva</h1>
            <a href="/reservas" class="text-sm text-gray-400 hover:text-white">← Voltar</a>
        </div>

        <form action="/reservas/salvar-meta" method="POST" class="space-y-4 bg-[#1b233d] p-6 rounded-2xl border border-gray-800 shadow-lg">
            @csrf 

            <div>
                <label class="block text-xs text-gray-400 uppercase font-semibold mb-1">Nome do Objetivo</label>
                <input type="text" name="name" required placeholder="Ex: Viagem, Carro Novo, PS5..." class="w-full bg-[#121829] border border-gray-800 rounded-xl p-3 text-sm text-white focus:outline-none focus:border-blue-500">
            </div>

            <div>
                <label class="block text-xs text-gray-400 uppercase font-semibold mb-1">Valor Alvo / Preço (R$)</label>
                <input type="number" step="0.01" name="target_amount" required placeholder="0.00" class="w-full bg-[#121829] border border-gray-800 rounded-xl p-3 text-sm text-white focus:outline-none focus:border-blue-500">
            </div>

            <div>
                <label class="block text-xs text-gray-400 uppercase font-semibold mb-1">Valor Inicial Já Guardado (Opcional)</label>
                <input type="number" step="0.01" name="current_amount" placeholder="0.00" class="w-full bg-[#121829] border border-gray-800 rounded-xl p-3 text-sm text-white focus:outline-none focus:border-blue-500">
            </div>

            <div>
                <label class="block text-xs text-gray-400 uppercase font-semibold mb-1">URL da Imagem (Opcional)</label>
                <input type="url" name="image_url" placeholder="https://exemplo.com/imagem.jpg" class="w-full bg-[#121829] border border-gray-800 rounded-xl p-3 text-sm text-white focus:outline-none focus:border-blue-500">
            </div>

            <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 font-bold p-3 rounded-xl transition mt-2 shadow-lg">
                Criar Meta 🚀
            </button>
        </form>
    </main>

</body>
</html>