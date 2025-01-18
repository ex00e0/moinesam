@extends('layout.header')

@section('content')
    @foreach ($info as $i)
        {{$i->id}}
        {{$i->title}}
        {{$i->description}}
        <img src="{{asset("img/".$i->image)}}" alt="{{$i->title}}">
    @endforeach
@endsection