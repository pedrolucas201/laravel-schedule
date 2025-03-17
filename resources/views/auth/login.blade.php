@extends('layouts.admin')

@section('content')
    <form action="{{ route('login.post') }}" method="POST">
        @csrf
        <!-- Campos do formulário de login -->
        <br>
        <div class="form-group">
            <label for="email">E-mail</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}">
        </div>
        <div class="form-group">
            <label for="password">Senha</label>
            <input type="password" name="password" id="password" class="form-control">
        </div><br>

        <button type="submit" class="btn btn-primary">Entrar</button>
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
