<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Badanha Finance - Login</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-[#121829] text-white font-sans min-h-screen flex flex-col justify-center p-6">

    <div class="max-w-md w-full mx-auto bg-[#1b233d] p-6 rounded-2xl border border-gray-800 shadow-lg">
        <h1 class="text-2xl font-black text-center mb-2">Badanha<span class="text-blue-500">Finance</span></h1>
        <p class="text-gray-400 text-sm text-center mb-6">Entre com suas credenciais para gerenciar suas finanças.</p>

        @if ($errors->any())
            <div class="bg-red-900/50 border border-red-500 text-red-200 p-3 rounded-xl text-xs mb-4">
                <ul class="list-disc pl-4">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="/login" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-xs text-gray-400 uppercase font-semibold mb-1">E-mail</label>
                <input type="email" name="email" required value="{{ old('email') }}" placeholder="seu@email.com" class="w-full bg-[#121829] border border-gray-800 rounded-xl p-3 text-sm text-white focus:outline-none focus:border-blue-500">
            </div>

            <div>
                <label class="block text-xs text-gray-400 uppercase font-semibold mb-1">Senha</label>
                <input type="password" name="password" required placeholder="••••••••" class="w-full bg-[#121829] border border-gray-800 rounded-xl p-3 text-sm text-white focus:outline-none focus:border-blue-500">
            </div>

            <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 font-bold p-3 rounded-xl transition mt-4 shadow-lg">
                Entrar 
            </button>
        </form>

        <p class="text-sm text-gray-400 text-center mt-6">
            Não tem uma conta? <a href="/cadastro" class="text-blue-400 hover:underline">Cadastre-se</a>
        </p>
    </div>

</body>
</html>