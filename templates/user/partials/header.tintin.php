<section class="user-header text-left bg-light" style="padding-top: 5px; padding-bottom: 0px; border-radius: 0">
  <header class="container">
    <div class="row">
      <div class="col-sm-2">
        <img class="img-cover img-circle img-responsive"
          src="{{ gravatar($user->email, 250) }}"
          alt="{{ $user->name }}"
          style="width: 120px; height: 120px; position: relative; top: 5px; background-color: #eee">
      </div>
      <div class="col-sm-8">
        <div class="visible-xs" style="margin-top: 5px;">&nbsp;</div>
        <h2>{{ $user->name }}</h2>
        <p><b>Membre depuis {{ $user->created_at->format("d/m/Y") }}</b> - <span>{{ $user->comments()->count() }} {{ __('user.header_comment_title') }} - {{ $user->bookmarks()->count() }} {{ __('user.header_favoris_title') }}</span></p>
      </div>
      %if($user->isPremium())
      <div class="col-sm-2">
        <p style="font-size: 10rem"><i class="fa fa-star text-warning"></i></p>
      </div>
      %endif
    </div>
    <div class="row" style="margin-top: 13px;">
      <div class="col-sm-12">
        <ul class="user-nav nav nav-tabs">
          <li class="{{ $active == 'bookmark' ? 'active' : '' }}">
            <a href="{{ route('user.bookmark') }}">
              <i style="width: 18px;" class="fa fa-bookmark"></i> {{ __('user.favoris_title') }}
            </a>
          </li>
          <li class="{{ $active == 'transaction' ? 'active' : '' }}">
            <a href="{{ route('user.transaction') }}">
              <i style="width: 18px;" class="fa fa-star"></i> Paiements
            </a>
          </li>
          <li class="{{ $active == 'notification' ? 'active' : '' }}">
            <a href="{{ route('user.notification') }}">
              <i style="width: 18px;" class="fa fa-bell"></i> Notification
            </a>
          </li>
          <li class="{{ $active == 'setting' ? 'active' : '' }}">
            <a href="{{ route('user.setting') }}">
              <i style="width: 18px;" class="fa fa-cog"></i> {{ __('navbar.setting') }}
            </a>
          </li>
        </ul>
      </div>
    </div>
  </header>
</section>
