@extends('layouts.mail')

@section('content')

  <p>Добро пожаловать на наш сайт!</p>

  <p>
    Для входа в личный кабинет перейдите по ссылке ниже:
  </p>

  <p class="m-t-20">
    <a href="{{ env('APP_URL') }}" target="_blank" class="btn btn-primary">Войти в личный кабинет</a>
  </p>

  <p>
    Ваш пароль: <strong>{{$password}}</strong>
  </p>

@endsection
