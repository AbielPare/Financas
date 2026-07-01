<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Badanha Finance - Nova Transação</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-[#121829] text-white font-sans min-h-screen flex flex-col justify-between">

    <main class="p-6 max-w-md mx-auto w-full flex-grow">
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-xl font-bold">Nova Transação</h1>
            <a href="/home" class="text-sm text-gray-400 hover:text-white">← Voltar</a>
        </div>

        <form action="/transacao/salvar" method="POST" class="space-y-4 bg-[#1b233d] p-6 rounded-2xl border border-gray-800 shadow-lg">
            @csrf 

            <div>
                <label class="block text-xs text-gray-400 uppercase font-semibold mb-1">Descrição</label>
                <input type="text" name="description" required placeholder="Ex: Mercado, Freelance..." class="w-full bg-[#121829] border border-gray-800 rounded-xl p-3 text-sm text-white focus:outline-none focus:border-blue-500">
            </div>

            <div>
                <label class="block text-xs text-gray-400 uppercase font-semibold mb-1">Valor (R$)</label>
                <input type="number" step="0.01" name="amount" required placeholder="0.00" class="w-full bg-[#121829] border border-gray-800 rounded-xl p-3 text-sm text-white focus:outline-none focus:border-blue-500">
            </div>

            <div>
                <label class="block text-xs text-gray-400 uppercase font-semibold mb-1">Tipo</label>
                <select name="type" required class="w-full bg-[#121829] border border-gray-800 rounded-xl p-3 text-sm text-white focus:outline-none focus:border-blue-500">
                    <option value="income">Faturamento / Renda (+)</option>
                    <option value="expense">Gasto / Despesa (-)</option>
                </select>
            </div>

            <div>
                <label class="block text-xs text-gray-400 uppercase font-semibold mb-1">Categoria</label>
                <input type="text" name="category" required placeholder="Ex: Alimentação, Lazer, Transporte" class="w-full bg-[#121829] border border-gray-800 rounded-xl p-3 text-sm text-white focus:outline-none focus:border-blue-500">
            </div>

            <div>
                <label class="block text-xs text-gray-400 uppercase font-semibold mb-1">Data</label>
                <input type="date" name="date" required value="{{ date('Y-m-d') }}" class="w-full bg-[#121829] border border-gray-800 rounded-xl p-3 text-sm text-white focus:outline-none focus:border-blue-500">
            </div>
            <!-- Tipo de Recorrência -->
            <div>
                <label class="block text-xs text-gray-400 uppercase font-semibold mb-1">Tipo de Lançamento</label>
                <select name="recurrence_type" id="recurrence_type" required onchange="toggleInstallmentsField()" class="w-full bg-[#121829] border border-gray-800 rounded-xl p-3 text-sm text-white focus:outline-none focus:border-blue-500">
                    <option value="unique">Único (gasto/ganho pontual)</option>
                    <option value="fixed">Fixo Mensal (Ex: Internet, Netflix)</option>
                    <option value="installments">Parcelado (Ex: Cartão, Carro)</option>
                </select>
            </div>

            <!-- Campo dinâmico de parcelas (Inicia escondido) -->
            <div id="installments_field" class="hidden">
                <label class="block text-xs text-gray-400 uppercase font-semibold mb-1">Número de Parcelas</label>
                <input type="number" name="installments" min="2" placeholder="Ex: 48" class="w-full bg-[#121829] border border-gray-800 rounded-xl p-3 text-sm text-white focus:outline-none focus:border-blue-500">
            </div>

    <!-- Script em js para exibir/esconder o campo de parcelas -->
    <script>
        function toggleInstallmentsField() {
            const select = document.getElementById('recurrence_type');
            const field = document.getElementById('installments_field');
        
            if (select.value === 'installments') {
                field.classList.remove('hidden');
                field.querySelector('input').setAttribute('required', 'required');
            } else {
                field.classList.add('hidden');
                field.querySelector('input').removeAttribute('required');
            }
        }
    </script>

            <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 font-bold p-3 rounded-xl transition mt-2 shadow-lg">
                Salvar Transação
            </button>
        </form>
    </main>

</body>
</html>