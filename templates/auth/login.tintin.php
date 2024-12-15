%extends('layouts.app', ['active' => 'login', 'body_class' => 'bg-image', 'without_footer' => true])

%block('title', 'Connexion à votre espace')

%block('description')
<meta name="description" content="Connexion à votre espace">
<meta name="author" content="Franck DAKIA">
%endblock

%block('twitter')
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:site" content="%franck_dakia">
  <meta name="twitter:creator" content="%franck_dakia">
  <meta name="twitter:title" content="Connectez-vous ou créez une compte sur {{ app_env('APP_NAME') }}">
  <meta name="twitter:description" content="{{ __('auth.login_motivation') }}">
  <meta name="twitter:image:src" content="{{ app_env('APP_URL') }}/img/brand/logo.png">
%endblock

%block('facebook')
  <meta property="og:url" content="{{ route('login') }}">
  <meta property="og:title" content="Connectez-vous ou créez une compte sur {{ app_env('APP_NAME') }}">
  <meta property="og:description" content="{{ __('auth.login_motivation') }}">
  <meta property="og:type" content="profile">
  <meta property="og:site_name" content="{{ app_env('APP_NAME') }}" />
  <meta property="og:image" content="{{ app_env('APP_URL') }}/img/brand/logo.png">
  <meta property="profile:username" content="{{ app_env('APP_NAME') }}" />
%endblock

%block('content')
<div class="container">
  <div class="row">
    <div class="hidden-xs col-sm-offset-2 col-sm-4">
      %include('partials.what')
      <h4>{{ __('auth.why_login') }}</h4>
      <p>{{ __('auth.login_for.title') }}</p>
      <ul>
        <li>{{ __('auth.login_for.challenge') }}</li>
        <li>{{ __('auth.login_for.path') }}</li>
        <li>{{ __('auth.login_for.follow_your_progression') }}</li>
        <li>{{ __('auth.login_for.forum') }}</li>
        <li>{{ __('auth.login_for.tutorial') }}</li>
        <li>{{ __('auth.login_for.job') }}</li>
      </ul>
      <p class="text-info">{{ __('auth.login_motivation') }}</p>
    </div>
    <div class="col-sm-4 col-xs-12 shadow-sm auth-form animated fadeInRight" style="padding: 30px">
      %include('partials.loader')
      {## <h3>{{ __('auth.login_title') }}</h3> ##}
      %if(old('email'))
      <div class="alert alert-danger" role="alert">
        {{ __('auth.login_fail') }}
      </div>
      %endif
      %if(session('social_error'))
      <div class="alert alert-danger" role="alert">
        {{{ __('auth.social_error', ['name' => session('social_error')]) }}}
      </div>
      %endif
      %include('auth.social-link', ['title' => __('auth.login_with')])
    </div>
    <div class="visible-xs col-xs-offset-0 col-xs-12">
      <br>
      %include('partials.what')
      <h3>{{ __('auth.why_login') }}</h3>
      <p>{{ __('auth.login_for.title') }}</p>
      <ul>
        <li>{{ __('auth.login_for.challenge') }}</li>
        <li>{{ __('auth.login_for.forum') }}</li>
        <li>{{ __('auth.login_for.tutorial') }}</li>
      </ul>
      <p class="text-info">{{ __('auth.login_motivation') }}</p>
    </div>
  </div>
</div>
%endblock

%block('script')
<script type="text/javascript">
  $('.btn-login').click(function (e) {
    if (!$(e.target).hasClass('login-form-button')) {
      return $('.lds-ellipsis').fadeIn(100);
    }
    if ($('[name="email"]').val().length !== 0 && $('[name="password"]').val().length !== 0) {
      $('.lds-ellipsis').fadeIn(100);
    }
  });
</script>
%endblock
