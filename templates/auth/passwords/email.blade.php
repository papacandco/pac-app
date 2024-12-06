@extends('layouts.app', ['active' => 'login', 'isolate' => true, 'body_class' => 'bg-image', 'without_footer' => true])

@section('title', __('passwords.title'))

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
      <h3>{{ __('passwords.title') }}</h3>
      <p>
        {{ __('passwords.description') }}
      </p>
      @if($errors->has('email'))
      <div class="alert alert-danger" role="alert">
        {{ $errors->first('email') }}
      </div>
      @endif
      @if(session()->has('success'))
      <div class="alert alert-success" role="alert">
        {{ session('success') }}
      </div>
      @endif
      <form action="{{ route('password.email') }}" method="POST">
        @csrf
        <div class="form-group">
          <input id="email" type="email" placeholder="Entrez votre email"
          class="form-control" name="email" value="{{ old('email') }}" required>
        </div>
        <div class="form-group">
          <button class="btn btn-primary btn-block btn-login">{{ __('passwords.btn_label') }}</button>
        </div>
        <div class="form-group">
          <div>
            <a href="{{ route('login') }}" style="text-decoration: underline">{{ __('passwords.login') }}</a>
          </div>
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
