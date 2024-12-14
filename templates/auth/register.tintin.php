%extends('layouts.app', ['active' => 'register', 'body_class' => 'bg-image', 'without_footer' => true])

%block('title', 'Créez un compte')

%block('description')
<meta name="description" content="Créez un compte sur Papac & Co">
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
<div class="container" style="padding: 50px;">
  <div class="row">
    <div class="hidden-xs col-sm-offset-2 col-xs-offset-0 col-sm-4 col-xs-12">
      %include('partials.what')
      <h3>{{ __('register.why_register') }}</h3>
      <p>{{ __('register.register_for.title') }}</p>
      <ul>
        <li>{{ __('register.register_for.formation') }}</li>
        <li>{{ __('register.register_for.challenge') }}</li>
        <li>{{ __('register.register_for.forum') }}</li>
        <li>{{ __('register.register_for.free') }}</li>
      </ul>
      <p class="text-info">
        {{{ __('register.register_motivation', ['url' => route('terms')]) }}}
      </p>
    </div>
    <div class="col-sm-4 col-xs-12 shadow-sm auth-form">
      %include('partials.loader')
      <h3>{{ __('register.title') }}</h3>
      %if (session('social_error'))
      <div class="alert alert-danger" role="alert">
        {{{ __('auth.social_error', ['name' => session('social_error')]) }}}
      </div>
      %endif
      <form action="{{ route('register') }}" method="POST">
        %csrf
        <div class="form-group">
          <input type="text" name="name" class="form-control" placeholder="{{ __('register.name') }}"
            value="{{ old('name') }}" required />
        </div>
        <div class="form-group">
          <input type="email" name="email" class="form-control" placeholder="{{ __('register.email') }}"
            value="{{ old('email') }}" required />
        </div>
        <div class="form-group select">
          <select name="country" class="form-control" required>
            %foreach(get_country_list() as $country)
              <option value="{{ $country->code }}" {{ old('country') == $country->code ? 'selected' : '' }}>{{ $country->name }}</option>
            %endforeach
          </select>
          <div class="select__arrow"></div>
        </div>
        <div class="form-group select">
          <select name="sexe" class="form-control" required>
            <option value="man" {{ old('sexe') == 'man' ? 'selected' : '' }}>{{ __('register.man') }}</option>
            <option value="woman" {{ old('sexe') == 'woman' ? 'selected' : '' }}>{{ __('register.woman') }}</option>
          </select>
          <div class="select__arrow"></div>
        </div>
        <div class="form-group">
          <input type="password" name="password" class="form-control" placeholder="Votre mot de passe"
            value="{{ old('password') }}" required />
        </div>
        <div class="form-group">
          <input type="password" name="password_confirmation" class="form-control"
            placeholder="Confirmez votre mot de passe" required />
        </div>
        <div class="checkbox">
          <label class="control control--radio">
            <input type="checkbox" name="condition" required/> <span style="position: relative; top: -3px; right: -5px">{{{ __('register.accept_contract', ['url' => 'condition-utilisation']) }}}</span>
            <div class="control__indicator"></div>
          </label>
        </div>
        <div class="form-group">
          <button type="submit"
            class="btn btn-primary btn-block btn-login register-form-button">{{ __('register.btn') }}</button>
        </div>
        <div class="form-group">
          <div>
            <a href="{{ route('login') }}" style="text-decoration: underline">{{ __('register.login') }}</a>
          </div>
        </div>
      </form>
      <hr>
      %include('auth.social-link', ['title' => __('register.register_with')])
    </div>
    <div class="visible-xs col-xs-offset-0 col-xs-12">
      <br>
      %include('partials.what')
      <h3>{{ __('register.why_register') }}</h3>
      <p>{{ __('register.register_for.title') }}</p>
      <ul>
        <li>{{ __('register.register_for.formation') }}</li>
        <li>{{ __('register.register_for.challenge') }}</li>
        <li>{{ __('register.register_for.forum') }}</li>
        <li>{{ __('register.register_for.free') }}</li>
      </ul>
      <p class="text-info">
        {{{ __('register.register_motivation', ['url' => route('terms')]) }}}
      </p>
    </div>
  </div>
</div>
%include('partials.information')
%endblock

%block('script')
<script type="text/javascript">
  let $password = $('[name="password"]');
  let $passwordConfirmation = $('[name="password_confirmation"]');
  $password.on('focus', function () {
    $password.css('border-color', '#eee');
  });
  $passwordConfirmation.on('focus', function () {
    $passwordConfirmation.css('border-color', '#eee');
  });

  $('.btn-login').click(function (e) {
    if (!$(e.target).hasClass('register-form-button')) {
      return $('.lds-ellipsis').fadeIn(100);
    }

    let $name = $('[name="name"]');
    let $email = $('[name="email"]');
    let $password = $('[name="password"]');
    let $passwordConfirmation = $('[name="password_confirmation"]');

    if ($name.val().length !== 0 &&
      $email.val().length !== 0 &&
      $password.val().length !== 0 &&
      $passwordConfirmation.val().length !== 0
    ) {
      if ($passwordConfirmation.val() !== $password.val()) {
        window.showInfo('Les mots de passe ne sont pas les mêmes.');
        $passwordConfirmation.css('border-color', '#fd385b');
        $password.css('border-color', '#fd385b');
        return e.preventDefault();
      }
      let condition = document.querySelector('[name="condition"]');
      if (condition.checked) {
        return $('.lds-ellipsis').fadeIn(100);
      }
    }
  });
</script>
%endblock
