<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Exibe a tela de cadastro
    public function showCadastro()
    {
        return view('auth.cadastro');
    }

    // Processa o registro do novo usuário
    public function register(Request $request)
    {
        // 1. Valida os dados recebidos
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed', // exige o campo password_confirmation
        ]);

        // 2. Cria o usuário no banco (com a senha criptografada!)
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Criptografia Bcrypt
        ]);

        // 3. Loga o usuário automaticamente após o cadastro
        Auth::login($user);

        // 4. Redireciona para a Home
        return redirect('/home');
    }

    // Exibe a tela de login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Processa o acesso do usuário
    public function login(Request $request)
    {
        // 1. Valida as credenciais digitadas
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // 2. Tenta fazer o login (O Laravel checa o e-mail e a senha com o Hash automaticamente)
        if (Auth::attempt($credentials)) {
            // Regenera a sessão por segurança
            $request->session()->regenerate();

            return redirect()->intended('/home');
        }

        // 3. Se errar o e-mail ou a senha, volta com uma mensagem de erro
        return back()->withErrors([
            'email' => 'As credenciais fornecidas não batem com nossos registros.',
        ])->onlyInput('email');
    }

    // Faz o logout (Sair da conta)
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}