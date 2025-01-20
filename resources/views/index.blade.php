@extends('layout.header')
@section('title', 'Главная')
@section('content')

@error('message')
<script>alert("{{$message}}");</script>
@enderror



@endsection