<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ContactsExport;

class ContactController extends Controller
{
    // Listar os contatos do usuário autenticado
    public function index(Request $request)
    {
        // Filtro de contatos com base no status
        $filter = $request->get('filter', 'all'); // Padrão para 'all' se não especificado
    
        switch ($filter) {
            case 'active':
                // Exibe apenas os contatos ativos (sem exclusão)
                $contacts = auth()->user()->contacts()->whereNull('deleted_at')->get();
                break;
    
            case 'deleted':
                // Exibe apenas os contatos excluídos
                $contacts = auth()->user()->contacts()->onlyTrashed()->get();
                break;
    
            default:
                // Exibe todos os contatos, incluindo ativos e excluídos
                $contacts = auth()->user()->contacts()->withTrashed()->get();
                break;
        }
    
        return view('contacts.index', compact('contacts'));
    }
    
    // Mostrar o formulário para criar um novo contato
    public function create()
    {
        return view('contacts.create');
    }

    // Armazenar um novo contato
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email|unique:contacts,email',
            'observation' => 'nullable',
        ]);

        // Criar o novo contato
        Contact::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'observation' => $request->observation,
            'user_id' => Auth::id(), // Relaciona o contato ao usuário autenticado
        ]);

        return redirect()->route('contact.index')->with('success', 'Contato criado com sucesso!');
    }

    // Mostrar o formulário de edição
    public function edit(Contact $contact)
    {
        // Verificar se o contato existe
        if ($contact->user_id !== Auth::id()) {
            return redirect()->route('contact.index')->withErrors('Você não tem permissão para editar este contato.');
        }

        // Verificar se o contato pertence ao usuário autenticado
        if ($contact->user_id !== Auth::id()) {
            return redirect()->route('contacts.index')->withErrors('Você não tem permissão para editar este contato.');
        }

        return view('contacts.edit', compact('contact'));
    }

    // Atualizar o contato
    public function update(Request $request, Contact $contact)
    {

        // Verificar se o contato pertence ao usuário autenticado
        if ($contact->user_id !== Auth::id()) {
            return redirect()->route('contact.index')->withErrors('Você não tem permissão para atualizar este contato.');
        }

        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email|unique:contacts,email,' . $contact->id,
            'observation' => 'nullable',
        ]);

        $contact->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'observation' => $request->observation,
        ]);

        return redirect()->route('contacts.index')->with('success', 'Contato atualizado com sucesso!');
    }

    public function show(Contact $contact)
    {

        // Carregar o contato com as informações atualizadas
        $contact = Contact::find($contact->id);

        // Verificar se o contato existe
        if (!$contact) {
            return redirect()->route('contacts.index')->withErrors('Contato não encontrado.');
        }
        // Verificar se o contato pertence ao usuário autenticado
        if ($contact->user_id !== Auth::id()) {
            return redirect()->route('contacts.index')->withErrors('Você não tem permissão para visualizar este contato.');
        }

        return view('contacts.show', compact('contact'));
    }

    // Excluir um contato
    public function destroy(Contact $contact)
    {
        // Verificar se o contato pertence ao usuário autenticado
        if ($contact->user_id !== Auth::id()) {
            return redirect()->route('contact.index')->withErrors('Você não tem permissão para excluir este contato.');
        }

        // Verificar se o contato pertence ao usuário autenticado
        if ($contact->user_id !== Auth::id()) {
            return redirect()->route('contact.index')->withErrors('Você não tem permissão para excluir este contato.');
        }

        $contact->delete();
        return redirect()->route('contact.index')->with('success', 'Contato excluído com sucesso!');
    }
}
