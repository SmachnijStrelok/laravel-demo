@extends('layouts.mail')

@section('content')

  <p>Добро пожаловать на наш сайт!</p>

  <p>
    Для активации нажмите на кнопку ниже:
  </p>

  <p class="m-t-20">
    <a
        href="{{$activation_link}}"
        target="_blank"
        class="btn btn-primary"
    >
      Активировать аккаунт
    </a>
  </p>

@endsection
