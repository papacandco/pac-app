@extends('layouts.app', ['active' => 'login', 'isolate' => true, 'body_class' => 'bg-image', 'without_footer' => true])

@section('title', __('passwords.reset_title'))

@section('style')
  <style type="text/css">
    body.bg-image {
      background-size: cover !important;
    }
  </style>
@endsection

@section('content')
<div class="container" style="padding: 30px;">
  <div class="row">
    <div class="col-sm-offset-4 col-sm-4 col-xs-12 shadow-sm auth-form">
      @include('partials.loader')
      <h3>{{ __('passwords.reset_title') }}</h3>
      <p>
        {{ __('passwords.reset_descriptiom') }}
      </p>
      @if ($errors->has('password'))
      <div class="alert alert-danger" role="alert">
        {{ $errors->first('password') }}
      </div>
      @endif
      @if(session()->has('success'))
      <div class="alert alert-success" role="alert">
        {{ session('success') }}
      </div>
      @endif
      <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <div class="form-group">
          <input id="email" type="hidden" placeholder="Adresse email" class="form-control" name="email" value="{{ $email ?? old('email') }}" required autofocus>
        </div>
        <div class="form-group">
          <input id="password" type="password" placeholder="Nouveau mot de passe" class="form-control" name="password" required>
        </div>
        <div class="form-group">
          <input id="password-confirm" type="password" placeholder="Confirmer le mot de passe" class="form-control" name="password_confirmation" required>
        </div>
        <div class="form-group">
          <button class="btn btn-primary btn-block btn-login">
            {{ __('passwords.reset_btn_label') }}
          </button>
        </div>
      </form>
    </div>
  </div>
  <br>
  <br>
  @include('partials.copy-right', ['route' => route('terms')])
</div>
@endsection

@section('script')
<script type="text/javascript">
  $('.btn-login').click(function (e) {
    if ($('[name="email"]').val().length !== 0) {
      $('.lds-ellipsis').fadeIn(100);
    }
  });
</script>
@endsection
