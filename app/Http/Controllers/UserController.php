<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function index()
    {
        // Recuperar os registros do banco dados
        $users = User::orderByDesc('id')->get();

        // Carregar a VIEW
        return view('users.index', ['users' => $users]);
    }

    public function show(User $user)
    {
        return view('users.show', ['user' => $user]);
    }

    public function create()
    {
        // Carregar a VIEW
        return view('users.create');
    }

    public function store(Request $request)
    {
        // Validar o formulário
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email|unique:users',
            'observation' => 'nullable',
            'password' => 'required|min:6|confirmed',
        ]);

        // Cadastrar o usuário no BD
        User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'observation' => $request->observation,
            'password' => bcrypt($request->password),
        ]);

        // Redirecionar o usuário, enviar a mensagem de sucesso
        return redirect()->route('user.index')->with('success', 'Usuário cadastrado com sucesso!');
    }

    public function edit(User $user)
    {
        return view('users.edit', ['user' => $user]);
    }

    public function update(Request $request, User $user)
    {
        // Validar o formulário
        $request->validate([
            'name' => 'required',
            'phone' => 'nullable',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'observation' => 'nullable',
            'password' => 'nullable|min:6',
        ]);

        // Editar as informações do registro no banco de dados
        $user->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'observation' => $request->observation,
            'password' => $request->password ? bcrypt($request->password) : $user->password,
        ]);

        // Redirecionar o usuário, enviar a mensagem de sucesso
        return redirect()->route('user.show', ['user' => $user->id])->with('success', 'Usuário editado com sucesso!');
    }

    public function destroy(User $user)
    {
        // Apagar o registro no BD
        $user->delete();

        // Redirecionar o usuário, enviar a mensagem de sucesso
        return redirect()->route('user.index')->with('success', 'Usuário apagado com sucesso!');
    }
}
