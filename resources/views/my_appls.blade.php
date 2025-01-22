@extends('layout.header')
@section('title', 'Регистрация')
@section('content')

@error('message')
<script>alert("{{   $message}}");</script>
@enderror

@error('login')
<div class="alert alert-danger">{{ $message }}</div>
@enderror

@error('password')
<div class="alert alert-danger">{{ $message }}</div>
@enderror

@error('fio')
<div class="alert alert-danger">{{ $message }}</div>
@enderror

@error('phone')
<div class="alert alert-danger">{{ $message }}</div>
@enderror

@error('email')
<div class="alert alert-danger">{{ $message }}</div>
@enderror

<div class="vh2"></div>
<div class="container-fluid">
    <h3>Мои заявки</h3>
</div>
<div class="vh2"></div>
<div class="container-fluid">
    @if ($count !=0)
    @foreach ($appls as $appl)
<div class="card" style="width: 18rem;">
  <div class="card-body">
    <h5 class="card-title">$appl->type</h5>
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
    <a href="#" class="btn btn-primary">Go somewhere</a>
  </div>
</div>
@endforeach

@else
<div class="vh2">Нет заявок</div>
@endif
</div>

@endsection