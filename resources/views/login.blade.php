@extends('layout.header')
@section('title', 'Главная')
@section('content')

@error('message')
<script>alert("{{$message}}");</script>
@enderror

@guest
<form action="{{route('login')}}" method="POST">
    @csrf
    <label for="">login</label>
    <input type="text" name="login" value="{{ old('login') }}" id="">
    <label for="">pass</label>
    <input type="password" name="password" value="{{ old('password') }}" id="">
    
    <input type="submit" value="Войти">
</form>
@endguest

@auth
    <span>Авторизован</span>
@endauth

@endsection