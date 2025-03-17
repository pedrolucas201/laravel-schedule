@extends('layouts.admin')

@section('content')
    <div class="card mt-4 mb-4 border-light shadow">

        <div class="card-header hstack gap-2">
            <span>Listar Contatos</span>

            <span class="ms-auto">
                <a href="{{ route('contact.create') }}" class="btn btn-success btn-sm">Cadastrar</a>
            </span>
        </div>

        <div class="card-body">

            <x-alert />

            <!-- Filtro de status -->
            <form method="GET" action="{{ route('contact.index') }}" class="mb-3">
                <div class="form-group">
                    <label for="filter">Filtrar contatos</label>
                    <select name="filter" id="filter" class="form-control" onchange="this.form.submit()">
                        <option value="all" {{ request('filter') == 'all' ? 'selected' : '' }}>Todos</option>
                        <option value="active" {{ request('filter') == 'active' ? 'selected' : '' }}>Ativos</option>
                        <option value="deleted" {{ request('filter') == 'deleted' ? 'selected' : '' }}>Excluídos</option>
                    </select>
                </div>
            </form>

            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Telefone</th>
                        <th scope="col">E-mail</th>
                        <th scope="col">Observações</th>
                        <th scope="col">Status</th>
                        <th scope="col" class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>

                    @forelse ($contacts as $contact)
                        <tr>
                            <th>{{ $contact->id }}</th>
                            <td>{{ $contact->name }}</td>
                            <td>{{ $contact->phone }}</td>
                            <td>{{ $contact->email }}</td>
                            <td class="text-center">{{ $contact->observation }}</td>
                            <td class="text-center">
                                @if($contact->trashed())
                                    <span class="badge bg-danger">Excluído</span>
                                @else
                                    <span class="badge bg-success">Ativo</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('contact.show', ['contact' => $contact->id]) }}" class="btn btn-primary btn-sm">Visualizar</a>
                                <a href="{{ route('contact.edit', ['contact' => $contact->id]) }}" class="btn btn-warning btn-sm">Editar</a>
                                <form method="POST" action="{{ route('contact.destroy', ['contact' => $contact->id]) }}" class="d-inline">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja apagar este registro?')">Apagar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Nenhum contato encontrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
