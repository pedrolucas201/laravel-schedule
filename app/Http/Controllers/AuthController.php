<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;  
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login'); // Retorna a view do formulário de login
    }
    
    public function login(Request $request)
    {
        // Validação das credenciais
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Verificar se o usuário existe
        $user = User::where('email', $request->email)->first();

        // Se o usuário não existir ou a senha estiver incorreta
        if (!$user || !Hash::check($request->password, $user->password)) {
            // Redirecionar para login com erro
            return redirect()->route('login')->withErrors([
                'email' => 'As credenciais fornecidas estão incorretas.',
            ]);
        }

        // Fazer o login do usuário
        Auth::login($user);

        // Redirecionar para a página principal (exemplo: dashboard)
        return redirect()->route('contact.index')->with('success', 'Login realizado com sucesso!');
    }    
    
    public function logout(Request $request)
    {
        // Se estiver usando tokens (Laravel Sanctum ou Passport)
        if ($request->user()) {
            $request->user()->tokens()->delete(); // Remove todos os tokens do usuário
        }
    
        // Faz logout do usuário autenticado (para sessões normais)
        Auth::logout();
    
        // Invalida a sessão e gera um novo token CSRF
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    
        // Redireciona para a tela de login com uma mensagem
        return redirect()->route('login')->with('message', 'Você foi desconectado com sucesso!');
    }
    
        

    public function register(Request $request)
    {
        // Verificação personalizada antes de validar os dados
        if (!$request->has('name') || !$request->has('phone') || !$request->has('email') || !$request->has('password')) {
            return redirect()->back()->with('error', 'Todos os campos obrigatórios devem ser preenchidos!');
        }
    
        // Validação dos dados
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email|unique:users',
            'observation' => 'nullable',
            'password' => 'required|min:6',
        ]); 
    
        // Criação do usuário
        $user = User::create([
            'name' => $request->name,
            'phone' => $request->phone ?? null, // Evitar erro caso phone não seja enviado
            'email' => $request->email,
            'observation' => $request->observation ?? null, // Evitar erro caso observation não seja enviado
            'password' => Hash::make($request->password),
        ]);
        
        // Criação do token de acesso para o usuário
        $token = $user->createToken('Cadastro de usuário')->plainTextToken;
        
        // Redirecionar para a página de login com uma mensagem de sucesso
        return redirect()->route('login')->with('success', 'Cadastro realizado com sucesso!');
    }
    
    public function showRegisterForm()
    {
        return view('auth.register'); // Retorna a view do formulário de registro
    }
    

}

