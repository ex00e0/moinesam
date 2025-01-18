@extends('layout.header')
@section('title', 'Главная')
@section('content')

@if ($errors->any())
            @foreach ($errors->all() as $error)
            <script>alert("{{$error}}");</script>
            @endforeach
       
@endif


{{isset($event_id)}}

<form action="{{isset($event_id) && $event_id != null ? route('update_event') : route('create_event')}}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" id="" value="{{isset($one_event->id) && $one_event->id!= null ? $one_event->id : old('id')}}">
    <label for="">Заголовок</label> 
    <input type="text" name="title" id="" value="{{isset($one_event->title) && $one_event->title!= null ? $one_event->title : old('title')}}">
    <label for="">Подзаголовок</label> 
    <input type="text" name="subtitle" id="" value="{{isset($one_event->subtitle) && $one_event->subtitle!= null ? $one_event->subtitle : old('subtitle')}}">
    <label for="">Ограничение</label> 
    <select name="age" id="">
        <option {{old('age') == 0  || (isset($one_event->age) && $one_event->age!= null && $one_event->age == 0) ? 'required' : ""}} value="0">0</option>
        <option {{old('age') == 3  || (isset($one_event->age) && $one_event->age!= null && $one_event->age == 3) ? 'required' : ""}} value="3">3</option>
        <option {{old('age') == 6  || (isset($one_event->age) && $one_event->age!= null && $one_event->age == 6) ? 'required' : ""}} value="6">6</option>
        <option {{old('age') == 12 || (isset($one_event->age) && $one_event->age!= null && $one_event->age == 12) ? 'required' : ""}} value="12">12</option>
        <option {{old('age') == 18 || (isset($one_event->age) && $one_event->age!= null && $one_event->age == 18) ? 'required' : ""}} value="18">18</option>
    </select>
    <label for="long">Длительность (мин.)</label>
    <input type="number" name="long" id="" value="{{isset($one_event->long) && $one_event->long!= null ? $one_event->long : old('long')}}">
    <label for="date">Дата/время показа</label>
    <input type="datetime-local" name="date" id="" min="{{date('Y-m-d\Th:i')}}" value="{{isset($one_event->date) && $one_event->date!= null ? $one_event->date : old('date')}}">
    <label for="">Описание</label>
    <textarea name="description" id="">{{isset($one_event->description) && $one_event->description!= null ? $one_event->description : old('description')}}</textarea>
    <label for="">Коллектив</label>
    <textarea name="squad" id="">{{isset($one_event->squad) && $one_event->squad!= null ? $one_event->squad : old('squad')}}</textarea>
    <label for="">Изображение</label>
    <input type="file" name="image" id="" value="{{isset($one_event->image) && $one_event->image!= null ? $one_event->image : old('image')}}">
    
    <input type="submit" value="{{isset($event_id) && $event_id != null ? "Обновить" : "Создать"}}">
</form>
<br>
@if($count != 0)
<table>
    <?php
        $c = 0;
    ?>
    @foreach ($events as $event)
        <tr>
            <td><a href="{{route('admin_index', $event->id)}}">{{$event->title}}</a></td>
            <td>{{$event->subtitle}}</td>
            <td>{{$event->squad}}</td>
            <td>{{$event->image}}</td>
            <td><img width="50px" src="{{asset("images/".$event->image)}}" alt="img"></td>
            <td><a href="{{route('one_events', $event->id)}}">Подробнее</a></td>
            <td><a href="{{route('delete_event', $event->id)}}">Удалить</a></td>
        </tr>
        <?php
            $c++;
        ?>
    @endforeach
</table>
@else
    Мероприятий нет
@endif
@endsection
