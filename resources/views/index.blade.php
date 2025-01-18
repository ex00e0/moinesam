@extends('layout.header')
@section('title', 'Главная')
@section('content')

@error('message')
<script>alert("{{$message}}");</script>
@enderror

<header>
    <div class="r2 c2">Башкирский государственный театр оперы и балета</div>
</header>
<div class="xto">
    <div class="r1 c2 align-end color-grey">Дата основания</div>
    <div class="r2 c2 color-black">1938 г.</div>
    <div class="r1 c3 align-end color-grey">Репертуар</div>
    <div class="r2 c3 color-black">72 произведения</div>
    <div class="r1 c4 align-end color-grey">Абсолютно для всех</div>
    <div class="r2 c4 color-black">0+</div>
    <div class="r1-all c5 learn-more">Узнать подробнее</div>
</div>
<div class="premiere">
    <div class="headline c2 r1">Ближайшие премьеры</div>
    <div class="show_all c3 r1"><a href="{{route('get_all_events')}}">Показать все</a></div>
    <img src="{{asset('images/Arrow 1.svg')}}" class="show_all_arrow c4 r1">
    <div class="c2-5 r2 block_premieres">
    @foreach ($events as $event)
        <div class="pr_back" style="background-image: url('images/{{$event->image}}')">
            <div class="r1 c2 pr_date">
                <div><?=substr($event->date, 8, 2).".".substr($event->date, 5, 2).".".substr($event->date, 0, 4)." ".substr($event->date, 11, 5)?></div>
            </div>
            <div class="r1 c4 pr_age">
                <div>{{$event->age}}+</div>
            </div>
            <div class="r3 c2-all pr_name">{{$event->title}}</div>
            <div class="r4 c2-all pr_desc">{{$event->subtitle}}</div>
        </div>
    @endforeach
    </div>
</div>
<div class="red_line">
    <div>
        <div>Правила поведения</div>
        <div>Схема зала</div>
        <div>История театра</div>
        <div>Коллектив театра</div>
    </div>
</div>
<div class="news">
    <div class="headline c2 r1">Новости театра</div>
    <div class="show_all c3 r1"><a href="{{route('all_news')}}">Показать все</a></div>
    <img src="{{asset('images/Arrow 1.svg')}}" class="show_all_arrow c4 r1">
    <div class="c2-5 r2 block_news">
    @foreach ($news as $new)
        <div>
            <img class="c1 r1 new_img" src="{{asset('images/'.$new->image)}}">
            <div class="c1 r3 new_name">{{$new->title}}</div>
            <div class="c1 r3 new_date"><?=substr($new->created_at, 8, 2).".".substr($new->created_at, 5, 2).".".substr($new->created_at, 0, 4)?></div>
            <div class="c1 r4 new_desc">{{$new->description}}</div>
        </div>
     @endforeach


        <!-- <div>
            <img class="c1 r1 new_img" src="{{asset('images/Rectangle 153.jpg')}}">
            <div class="c1 r3 new_name">Академия вокального искусства Аскара Абдразакова</div>
            <div class="c1 r3 new_date">09.12.2022</div>
            <div class="c1 r4 new_desc">Завершилась первая сессия проекта «Академия вокального искусства Аскара Абдразакова». Слушателей ждали четыре насыщенных знаниями и эмоциями дня.</div>
        </div>
        <div>
            <img class="c1 r1 new_img" src="{{asset('images/Rectangle 153.jpg')}}">
            <div class="c1 r3 new_name">Академия вокального искусства Аскара Абдразакова</div>
            <div class="c1 r3 new_date">09.12.2022</div>
            <div class="c1 r4 new_desc">Завершилась первая сессия проекта «Академия вокального искусства Аскара Абдразакова». Слушателей ждали четыре насыщенных знаниями и эмоциями дня.</div>
        </div>
        <div>
            <img class="c1 r1 new_img" src="{{asset('images/Rectangle 153.jpg')}}">
            <div class="c1 r3 new_name">Академия вокального искусства Аскара Абдразакова</div>
            <div class="c1 r3 new_date">09.12.2022</div>
            <div class="c1 r4 new_desc">Завершилась первая сессия проекта «Академия вокального искусства Аскара Абдразакова». Слушателей ждали четыре насыщенных знаниями и эмоциями дня.</div>
        </div> -->
    </div>
</div>

@endsection