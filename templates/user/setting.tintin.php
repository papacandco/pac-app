%extends('layouts.app', ['active' => 'profile', 'navbar_with_shadow' => true])

%block('title', __('user.setting_title'))

%block('content')
%include('user.partials.header', ['active' => 'setting'])
<section class="container" style="margin-top: -20px; margin-bottom: 10px; padding: 20px;" data-theme-route="{{ route('user.setting.theme') }}">
  <div class="row">
    <div class="col-sm-12">
      <h3>{{ __('user.setting_title') }}</h3>
      <form action="{{ route('user.update') }}" method="post">
        %csrf
        <div class="form-group">
          <label for="name" class="control-label">{{ __('user.setting_name') }}: </label>
          <input type="text" name="name" value="{{ $user->name }}" class="form-control" id="name">
        </div>
        <div class="form-group">
          <label for="pseudo" class="control-label">{{ __('user.setting_pseudo') }}: </label>
          <input type="text" name="pseudo" value="{{ $user->pseudo }}" class="form-control" id="pseudo">
        </div>
        <div class="form-group">
          <label for="email" class="control-label">{{ __('user.setting_email') }}: </label>
          <input type="email" name="email" value="{{ $user->email }}" class="form-control" id="email">
        </div>
        <div class="form-group select">
          <select name="sexe" class="form-control" required>
            <option value="man" {{ old('sexe') == 'man' ? 'selected' : '' }}>{{ __('register.man') }}</option>
            <option value="woman" {{ old('sexe') == 'woman' ? 'selected' : '' }}>{{ __('register.woman') }}</option>
          </select>
          <div class="select__arrow"></div>
        </div>
        <div class="form-group select">
          <select name="country" class="form-control" required>
            %foreach(get_country_list() as $country)
              <option value="{{ $country->code }}" {{ $user->country == $country->code ? 'selected' : '' }}>{{ $country->name }}</option>
            %endforeach
          </select>
          <div class="select__arrow"></div>
        </div>
        %if ($user->provider_type && is_null($user->password))
        <div class="form-group">
          <div class="alert alert-info bg-white">
            {{{ __('user.update_password_with_provider', ['type' => $user->provider_type ]) }}}
          </div>
        </div>
        %endif
        <div class="form-group">
          <label class="control control--radio">
            <input type="checkbox" name="update_password"> {{ __('user.update_password') }}
            <div class="control__indicator"></div>
          </label>
        </div>
        <div>
          <div class="form-group">
            <label for="password" class="control-label">{{ __('user.setting_password') }}: </label>
            <input type="password" name="password" class="form-control" id="password" disabled>
          </div>
          <div class="form-group">
            <label for="password_confirmation" class="control-label">{{ __('user.setting_password_confirmation') }}: </label>
            <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" disabled>
          </div>
        </div>
        <div class="form-group" style="margin-top: 10px;">
          <button class="btn btn-primary">{{ __('user.setting_btn') }}</button>
        </div>
      </form>
    </div>
  </div>
</section>
%endsection

%block('script')
  <script style="text/javascript" src="/js/user-setting.js"></script>
%endsection
