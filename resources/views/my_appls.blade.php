@extends('layout.header')
@section('title', 'Мои заявки')
@section('content')

@error('message')
<script>alert("{{   $message}}");</script>
@enderror

<div class="vh2"></div>
<div class="container-fluid">
    <h3>Мои заявки</h3>
</div>
<div class="vh2"></div>
<div class="container-fluid" >
    @if ($count !=0)
    @foreach ($appls as $appl)
<div class="card" style="width: 25rem;">
  <div class="card-body">
    <h5 class="card-title">{{$appl->type}}</h5>
    @if ($appl->type == 'иная услуга')
    <p class="card-text">Описание услуги: {{$appl->text}}</p>
    @endif
    <p class="card-text">Тип оплаты: {{$appl->pay}}</p>
    <p class="card-text">Адрес: {{$appl->address}}</p>
    <p class="card-text">Номер телефона: {{$appl->phone}}</p>
    <p class="card-text">Дата уборки: {{substr($appl->date, 8, 2).'.'.substr($appl->date, 5, 2).'.'.substr($appl->date, 0, 4).' '.substr($appl->date, 11)}}</p>
    <p class="card-text"><font color="blue">Статус: {{$appl->status}}</font></p>
    @if ($appl->status == 'выполнено' || $appl->status == 'отменено')
            <p class="card-text"><font color="blue">Причина отказа: {{$appl->admin_text}}</font></p>
        @endif
    <!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->
  </div>
</div>
<div style="height:1vmax;"></div>
@endforeach

@else
<div class="vh2">Нет заявок</div>
@endif
</div>

@endsection