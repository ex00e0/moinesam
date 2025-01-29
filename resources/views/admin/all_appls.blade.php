@extends('layout.header')
@section('title', 'Все заявки')
@section('content')

@error('message')
<script>alert("{{   $message}}");</script>
@enderror

<div class="vh2"></div>
<div class="container-fluid">
    <h3>Все заявки</h3>
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
    <p class="card-text"><font color="#a7aafa">ФИО заказчика: {{$appl->fio}}</font></p>
    <p class="card-text">Тип оплаты: {{$appl->pay}}</p>
    <p class="card-text">Адрес: {{$appl->address}}</p>
    <p class="card-text">Номер телефона: {{$appl->phone}}</p>
    <p class="card-text">Дата уборки: {{substr($appl->date, 8, 2).'.'.substr($appl->date, 5, 2).'.'.substr($appl->date, 0, 4).' '.substr($appl->date, 11)}}</p>
    <p class="card-text"><font color="blue">Статус:</font></p>
    <form action="{{route('change_status')}}" method="POST" id="sh_form_{{$appl->id}}">
        @csrf
        <input type="hidden" value="{{$appl->id}}" name="id">
        <select name="status" class="form-control" id='sh_{{$appl->id}}' onchange="st_change('{{$appl->id}}')" value="{{$appl->status}}"  <?= $appl->status == 'выполнено' || $appl->status == 'отменено' ? 'disabled' : '' ?>>
            <option value="создано" <?= $appl->status == 'создано'? 'selected' : '' ?> >создано</option>
            <option value="в работе" <?= $appl->status == 'в работе'? 'selected' : '' ?>>в работе</option>
            <option value="выполнено" <?= $appl->status == 'выполнено'? 'selected' : '' ?>>выполнено</option>
            <option value="отменено" <?= $appl->status == 'отменено'? 'selected' : '' ?>>отменено</option>
        </select>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label" id="label_sh_{{$appl->id}}" style='display:none;'>Опишите причину отказа</label>
            <input type="text" class="form-control" id="input_sh_{{$appl->id}}" name="admin_text" style='display:none;'>
        </div>
        <button type="submit" class="btn btn-primary" style="<?= $appl->status == 'выполнено' || $appl->status == 'отменено' ? 'display:none;' : '' ?>">Отправить</button>
        @if ($appl->status == 'выполнено' || $appl->status == 'отменено')
            <p class="card-text"><font color="blue">Причина отказа: {{$appl->admin_text}}</font></p>
        @endif
    </form>
    
  </div>
</div>
<div style="height:1vmax;"></div>
@endforeach

@else
<div class="vh2">Нет заявок</div>
@endif
</div>

<script>
function st_change (id) {
    let val = document.getElementById(`sh_${id}`).value;
    if (val == 'отменено') {
      document.getElementById(`input_sh_${id}`).style.display = 'block';
      document.getElementById(`label_sh_${id}`).style.display = 'block';
      document.getElementById(`input_sh_${id}`).setAttribute('required', '');
    }
    else {
      document.getElementById(`input_sh_${id}`).style.display = 'none';
      document.getElementById(`label_sh_${id}`).style.display = 'none';
      document.getElementById(`input_sh_${id}`).removeAttribute('required');
    }
}

//   document.getElementById('sh').addEventListener('change', function () {
//     let val = document.getElementById('sh').value;

//     if (val == 'отменено') {
//       document.getElementById('input_sh').style.display = 'block';
//       document.getElementById('label_sh').style.display = 'block';
//       document.getElementById('input_sh').setAttribute('required', '');
//     }
//     else {
//       document.getElementById('input_sh').style.display = 'none';
//       document.getElementById('label_sh').style.display = 'none';
//       document.getElementById('input_sh').removeAttribute('required');
//       document.getElementById('sh_form').submit();
//     }
    
//   });
</script>

@endsection