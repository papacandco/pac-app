@if (!Cookie::get('cookie-contract'))
<div class="bg-light-blue text-center" id="cookie-contrat-message" style="padding: 5px; display: none !important;">
  {!! __('vendor.cookie', ['route' => route('terms')]) !!}&nbsp;<a href="#" id="cookie-contrat-button" data-ajaxify="{{ route('support.accept-cookie') }}" data-ajaxify-method="post" style="text-decoration: underline" data-hidden-element="#cookie-contrat-message" data-hidden>{{ __('navbar.ok') }}</a>
</div>
@endif

@auth
  @if (!auth()->user()->hasVerifiedEmail())
    <div class="bg-light-blue text-center" id="email-validation-message" style="padding: 5px">
      {!! __('vendor.email-validation-message', ['route' => route('verification.resend')]) !!}
    </div>
  @endif
@endauth

<header class="navbar navbar-default navbar-static-top" id="app-navbar">
  <div class="container">
    <div class="navbar-header">
      <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#header-navbar" aria-controls="header-navbar" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a href="{{ route('index') }}" class="navbar-brand">
        @include('partials.brand')
      </a>
    </div>
    <nav class="navbar-collapse collapse" id="header-navbar">
      <ul class="nav navbar-nav"> {{--  style="margin-right: 40px" --}}
        <li class="{{ $active == 'tutorial' ? 'active' : '' }}">
          <a href="{{ route('tutorial') }}">{{ __('navbar.tutorial') }}</a>
        </li>
        <li class="{{ $active == 'curriculum' ? 'active' : '' }}">
          <a href="{{ route('curriculum') }}">{{ __('navbar.course') }}</a>
        </li>
        <li class="{{ $active == 'forum' ? 'active' : '' }}">
          <a href="{{ route('forum') }}">{{ __('navbar.forum') }}</a>
        </li>
        <li class="{{ $active == 'podcast' ? 'active' : '' }}">
          <a href="{{ route('podcast') }}">{{ __('navbar.podcast') }}</a>
        </li>
{{--         <li class="{{ $active == 'challenge' ? 'active' : '' }}">
          <a href="{{ route('challenge') }}">
            {{ __('navbar.challenge') }} @if (challenge_in_progress())<i style="position: relative; top: -1px;" class="pulsate-fwd text-danger fa fa-circle" title="Un challenge en cours actuellement"></i>@endif
          </a>
        </li> --}}
      </ul>
      <ul class="nav navbar-nav navbar-right">
        {{-- <li id="change-theme-button" data-is-light="false">
          <a href="#">
            <i class="fa fa-sun" style="width: 18px;"></i>
          </a>
        </li> --}}
        @guest
          <li class="{{ $active == 'login' ? 'active' : '' }}">
            <a href="{{ route('login') }}{{ get_preview_url() }}">{{ __('navbar.register') }}</a>
          </li>
        @else
          <li>
            <a href="{{ route('user.notification') }}">
              <i class="fa fa-bell" style="width: 18px;" class="img-circle"></i>
            </a>
          </li>
          <li class="dropdown {{ $active == 'profile' ? 'active' : '' }}">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
              <img src="{{ gravatar(Auth::user()->email, 20) }}" class="img-circle" style="background-color: #eee"><span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
              <li><a href="{{ route('user.bookmark') }}"><i style="width: 18px;" class="fa fa-bookmark"></i> {{ __('user.favoris_title') }}</a></li>
              <li><a href="{{ route('user.notification') }}"><i style="width: 18px;" class="fa fa-bell"></i> Notification</a></li>
              <li><a href="{{ route('user.setting') }}"><i style="width: 18px;" class="fa fa-cog"></i> {{ __('navbar.setting') }}</a></li>
              <li>
                <a href="#" onclick="$('#logout-from').submit()"><i style="width: 18px;" class="fa fa-power-off text-danger"></i> {{ __('navbar.logout') }}</a>
                <form id="logout-from" action="{{ route('logout') }}" method="post">@csrf</form>
              </li>
            </ul>
          </li>
        @endguest
      </ul>
      <form action="{{ route('search.index') }}" class="navbar-form navbar-right" style="border-top: none;">
        <div class="input-group">
          <input class="search" name="q" type="text" placeholder="{{ __('navbar.search') }}"/><span class="bar"></span>
        </div>
      </form>
    </nav>
  </div>
</header>
