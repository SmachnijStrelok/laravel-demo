@extends('layouts.mail')

@section('content')

  <p>
    Для подтверждения изменения электронной почты введите данный код в окне ее изменения:
  </p>

  <p class="m-t-20">
    <strong>{{ $activation_code }}</strong>
  </p>

@endsection
