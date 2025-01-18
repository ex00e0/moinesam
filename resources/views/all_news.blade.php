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
    
    
    @foreach ($news as $new)
    @if($c % 4 == 1 || $c == 1)
<div class="news">
        @if ($c == 1)
        <div class="headline c2 r1">Новости театра</div>
    @endif
    <div class="c2-5 r2 block_news">
 @endif  
        <div>
            <img class="c1 r1 new_img" src="{{asset('images/'.$new->image)}}">
            <div class="c1 r3 new_name"><a href="{{route('one_news', $new->id)}}">{{$new->title}}</a></div>
            <div class="c1 r3 new_date"><?=substr($new->created_at, 8, 2).".".substr($new->created_at, 5, 2).".".substr($new->created_at, 0, 4)?></div>
            <div class="c1 r4 new_desc">{{$new->description}}</div>
        </div>
    
     @if($c % 4 == 4 || $c == 4)
</div>
</div>
@endif
        <?php
            $c++;
        ?>
         @endforeach
    
      

        @else
    <div class="no_data">
        <div>Новостей нет</div>
    </div>
@endif
<!-- 
<div class="line_more">
    <button>Смотреть еще</button>
</div> -->

@endsection