@extends('layouts.admin')

@section('content')

    <div class="card mt-4 mb-4 border-light shadow">

        <div class="card-header hstack gap-2">
            <span>Editar Usuário</span>

            <span class="ms-auto d-sm-flex flex-row">

                <a href="{{ route('contact.index') }}" class="btn btn-info btn-sm me-1">Listar</a>
                <a href="{{ route('contact.show', ['contact' => $contact->id]) }}" class="btn btn-primary btn-sm me-1">Visualizar</a>
            </span>
        </div>

        <div class="card-body">

            <x-alert />

            <form action="{{ route('contact.update', ['contact' => $contact->id]) }}" method="POST" class="row g-3">
                @csrf
                @method('PUT')

                <div class="col-md-12">
                    <label for="name" class="form-label">Nome</label>
                    <input type="text" name="name" class="form-control" id="name" placeholder="Nome completo"
                        value="{{ old('name', $contact->name) }}">
                </div>

                <div class="col-md-6">
                    <label for="phone" class="form-label">Telefone</label>
                    <input type="text" name="phone" class="form-control" id="phone" placeholder="Telefone do usuário"
                        value="{{ old('phone', $contact->phone) }}">
                </div>

                <div class="col-md-6">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="email" name="email" class="form-control" id="email"
                        placeholder="Melhor e-mail do usuário" value="{{ old('email', $contact->email) }}">
                </div>

                <div class="col-md-12">
                    <label for="name" class="form-label">Observações</label>
                    <input type="text" name="observation" class="form-control" id="observation" placeholder="Observações"
                        value="{{ old('observacoes', $contact->observation) }}">
                </div>
                
                <div class="col-12">
                    <button type="submit" class="btn btn-warning btn-sm">Salvar</button>
                </div>

            </form>
        </div>
    </div>
@endsection
