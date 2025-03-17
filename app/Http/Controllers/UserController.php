<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // Usuário autenticado, sem necessidade de carregar os contatos
        return redirect()->route('contact.index');
    }

    public function show(User $user)
    {
        return view('contacts.show', ['user' => $user]);
    }

    public function create()
    {
        return view('contacts.create');
    }

    public function store(Request $request)
    {
        // Validação para criação do usuário
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email|unique:users',
            'observation' => 'nullable',
            'password' => 'required|min:6|confirmed',
        ]);

        // Criação do usuário
        User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'observation' => $request->observation,
            'password' => bcrypt($request->password),
        ]);

        // Redirecionamento para a página inicial de contatos
        return redirect()->route('contacts.index')->with('success', 'Usuário cadastrado com sucesso!');
    }

    public function edit(User $user)
    {
        return view('contacts.edit', ['user' => $user]);
    }

    public function update(Request $request, User $user)
    {
        // Validação para atualização de informações
        $request->validate([
            'name' => 'required',
            'phone' => 'nullable',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'observation' => 'nullable',
            'password' => 'nullable|min:6',
        ]);

        // Atualizar o usuário no banco de dados
        $user->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'observation' => $request->observation,
            'password' => $request->password ? bcrypt($request->password) : $user->password,
        ]);

        // Redirecionamento para a página de exibição do usuário
        return redirect()->route('contact.show', ['user' => $user->id])->with('success', 'Usuário editado com sucesso!');
    }

    public function destroy(User $user)
    {
        // Excluir o usuário
        $user->delete();

        // Redirecionar para a página de contatos
        return redirect()->route('contacts.index')->with('success', 'Usuário apagado com sucesso!');
    }
}
