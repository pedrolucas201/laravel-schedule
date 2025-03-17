@extends('layouts.admin')

@section('content')
    <div class="container mt-5">
        <div class="alert alert-success text-center">
            <h4>Você foi desconectado com sucesso!</h4>
            <a href="{{ route('login') }}" class="btn btn-primary">Voltar para Login</a>
        </div>
    </div>
@endsection
