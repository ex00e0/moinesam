@extends('layout.header')
@section('title', 'Подать заявку')
@section('content')

@error('message')
<script>alert("{{$message}}");</script>
@enderror

@error('phone')
<div class="alert alert-danger">{{ $message }}</div>
@enderror


<div class="vh2"></div>
<div class="container-fluid">
    <h3>Подать заявку</h3>
</div>
<div class="vh2"></div>
<div class="container-fluid">
<form action="{{route('send_appl_db')}}" method="POST">
@csrf
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Адрес</label>
    <input type="text" class="form-control" id="exampleInputEmail1" name="address" required>
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Номер телефона</label>
    <input type="text" class="form-control" id="exampleInputPassword1" name="phone" required>
  </div>
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Дата и время уборки</label>
    <input type="datetime-local" class="form-control" id="exampleInputEmail1" name="date" required>
  </div>
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Вид услуги</label>
    <select name="type" class="form-control" id='sh'>
      <option value="общий клининг">общий клининг</option>
      <option value="генеральная уборка">генеральная уборка</option>
      <option value="послестроительная уборка">послестроительная уборка</option>
      <option value="химчистка ковров и мебели">химчистка ковров и мебели</option>
      <option value="иная услуга">иная услуга</option>
    </select>
  </div>
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label" id="label_sh" style='display:none;'>Опишите услугу</label>
    <input type="text" class="form-control" id="input_sh" name="text" style='display:none;'>
  </div>
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Тип оплаты</label>
    <select name="pay" class="form-control" >
      <option value="наличные">наличные</option>
      <option value="банковская карта">банковская карта</option>
    </select>
  </div>
  <button type="submit" class="btn btn-primary">Отправить</button>
</form>
</div>

<script>
  document.getElementById('sh').addEventListener('change', function () {
    let val = document.getElementById('sh').value;
    if (val == 'иная услуга') {
      document.getElementById('input_sh').style.display = 'block';
      document.getElementById('label_sh').style.display = 'block';
      document.getElementById('input_sh').setAttribute('required', '');
    }
    else {
      document.getElementById('input_sh').style.display = 'none';
      document.getElementById('label_sh').style.display = 'none';
      document.getElementById('input_sh').removeAttribute('required');
      
    }
  });
</script>

@endsection