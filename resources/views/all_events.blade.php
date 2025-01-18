@extends('layout.header')
@section('title', 'Главная')
@section('content')

@error('message')
<script>alert("{{$message}}");</script>
@enderror
<?php
        $c = 1;
    ?>
@if($count != 0)

<!-- <table> -->
 
    @foreach ($events as $event)
    @if($c % 3 == 1 || $c == 1)
    <div class="premiere">
        @if ($c == 1)
    <div class="headline c2 r1">Афиша</div>
    @endif
    <div class="c2-5 r2 block_premieres">
 @endif  
        <div class="pr_back" style="background-image: url('images/{{$event->image}}')">
            <div class="r1 c2 pr_date">
                <div><?=substr($event->date, 8, 2).".".substr($event->date, 5, 2).".".substr($event->date, 0, 4)." ".substr($event->date, 11, 5)?></div>
            </div>
            <div class="r1 c4 pr_age">
                <div>{{$event->age}}+</div>
            </div>
            <div class="r3 c2-all pr_name"><a href="{{route('one_events', $event->id)}}" style="color:white;">{{$event->title}}</a></div>
            <div class="r4 c2-all pr_desc">{{$event->subtitle}}</div>
        </div>
        @if($c % 3 == 3 || $c == 3)
</div>
</div>
@endif
      
        <?php
            $c++;
        ?>
    @endforeach
    @if ($count>$c)
        {{$c}}
        <div class="line_more">
            <button>Смотреть еще</button>
        </div>
    @endif


@else
    <div class="no_data">
        <div>Мероприятий нет</div>
    </div>
@endif






@endsection