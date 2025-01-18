@extends('layout.header')

@section('content')

@foreach ($events as $event)
{{$event->id}}
{{$event->title}}
{{$event->date}}<br>
@endforeach

@endsection