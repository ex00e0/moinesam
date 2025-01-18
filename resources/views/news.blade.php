@extends('layout.header')

@section('content')

@if ($errors->any())
    
            @foreach ($errors->all() as $error)
            <script>alert("{{$error}}");</script>
            @endforeach
      
@endif


<form action="{{isset($news_id) && $news_id != null ? route('update_news') : route('create_news')}}" method="post" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" id="" value="{{isset($one_news->id) && $one_news->id!= null ? $one_news->id : old('id')}}">
    <label for="">Заголовок</label> 
    <input type="text" name="title" id="" value="{{isset($one_news->title) && $one_news->title!= null ? $one_news->title : old('title')}}">
    <label for="">Описание</label>
    <textarea name="description" id="">{{isset($one_news->description) && $one_news->description!= null ? $one_news->description : old('description')}}</textarea>
    <label for="">Изображение</label>
    <input type="file" name="image" id="" value="{{isset($one_news->image) && $one_news->image!= null ? $one_news->image : old('image')}}">
    
    <input type="submit" value="{{isset($news_id) && $news_id != null ? "Обновить" : "Создать"}}">
</form>

@if ($count != 0)
    @foreach ($news as $new)
        {{$new->id}}
        {{$new->title}}
        <img height="50px" src="{{asset('img/'.$new->image)}}" alt="">
        {{$new->created_at}}
        <a href="{{route('one_news', $new->id)}}">Подробнее</a>
        <a href="{{route('news_u', $new->id)}}">Изменить</a>
        <a href="{{route('news_d', $new->id)}}">Удалить</a>
        <br>
    @endforeach
@else
    <span>Нет новостей</span>
@endif
    
@endsection