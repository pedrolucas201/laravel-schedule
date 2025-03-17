@extends('layouts.admin')

@section('content')
    <form action="{{ route('register.post') }}" method="POST">
        @csrf
        <!-- Campos do formulário de registro -->
        <div class="form-group">
            <label for="name">Nome</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control">
        </div>
        <div class="form-group">
            <label for="phone">Telefone</label>
            <input type="text" name="phone" id="phone" value="{{ old('phone') }}" class="form-control">
        </div>
        <div class="form-group">
            <label for="email">E-mail</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-control">
        </div>
        <div class="form-group">
            <label for="observation">Observações</label>
            <input type="text" name="observation" id="observation" value="{{ old('observation') }}" class="form-control">
        </div>
        <div class="form-group">
            <label for="password">Senha</label>
            <input type="password" name="password" id="password" class="form-control">
        </div><br>

        <button type="submit" class="btn btn-primary" style="display:flex; flex-direction:column; align-items:center">Registrar</button>
    </form>

    <!-- Exibir mensagens de erro -->
    @if($errors->any())
        <div class="alert alert-danger mt-3">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
@endsection
