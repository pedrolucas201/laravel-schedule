@extends('layouts.admin')

@section('content')
    <h1>Agenda de Contatos</h1>

    <a href="{{ route('contacts.create') }}">Adicionar Novo Contato</a>

    <ul>
        @foreach ($contacts as $contact)
            <li>
                {{ $contact->name }} - {{ $contact->phone }} - {{ $contact->email }}
                <a href="{{ route('contacts.edit', $contact) }}">Editar</a>
                <form action="{{ route('contacts.destroy', $contact) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Excluir</button>
                </form>
            </li>
        @endforeach
    </ul>
@endsection
