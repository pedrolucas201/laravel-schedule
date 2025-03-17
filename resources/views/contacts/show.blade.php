@extends('layouts.admin')

@section('content')
    <div class="card mt-4 mb-4 border-light shadow">

        <div class="card-header hstack gap-2">
            <span>Visualizar Usuário</span>

            <span class="ms-auto d-sm-flex flex-row">

                <a href="{{ route('contact.index') }}" class="btn btn-info btn-sm me-1">Listar</a>
                <a href="{{ route('contact.edit', ['contact' => $contact->id]) }}" class="btn btn-warning btn-sm me-1">Editar</a>
                <form method="POST" action="{{ route('contact.destroy', ['contact' => $contact->id]) }}">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-danger btn-sm me-1"
                        onclick="return confirm('Tem certeza que deseja apagar este registro?')">Apagar</button>
                </form>
            </span>
        </div>

        <div class="card-body">

            <x-alert />

            <dl class="row">

                <dt class="col-sm-3">ID</dt>
                <dd class="col-sm-9">{{ $contact->id }}</dd>

                <dt class="col-sm-3">Nome</dt>
                <dd class="col-sm-9">{{ $contact->name }}</dd>

                <dt class="col-sm-3">Telefone</dt>
                <dd class="col-sm-9">{{ $contact->phone }}</dd>

                <dt class="col-sm-3">E-mail</dt>
                <dd class="col-sm-9">{{ $contact->email }}</dd>

                <dt class="col-sm-3">Observações</dt>
                <dd class="col-sm-9">{{ $contact-> observation }}</dd>

                <dt class="col-sm-3">Cadastrado</dt>
                <dd class="col-sm-9">{{ \Carbon\Carbon::parse($contact->created_at)->format('d/m/Y H:i:s') }}</dd>

                <dt class="col-sm-3">Editado</dt>
                <dd class="col-sm-9">{{ \Carbon\Carbon::parse($contact->updated_at)->format('d/m/Y H:i:s') }}</dd>

            </dl>
        </div>
    </div>
@endsection
