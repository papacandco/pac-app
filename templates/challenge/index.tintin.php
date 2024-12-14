%extends('layouts.app', ['active' => 'challenge'])

%block('title', __('challenge.title'))

%block('twitter')
<meta name="twitter:card" content="summary">
<meta name="twitter:site" content="%franck_dakia">
<meta name="twitter:creator" content="%franck_dakia">
<meta name="twitter:title" content="{{ __('challenge.title') }}">
<meta name="twitter:description" content="{{ __('challenge.description') }}">
<meta name="twitter:image" content="{{ app_env('APP_URL') }}/img/brand/logo.png">
%endsection

%block('facebook')
<meta property="og:url" content="{{ route('challenge') }}">
<meta property="og:title" content="{{ __('challenge.title') }}">
<meta property="og:description" content="{{ __('challenge.description') }}">
<meta property="og:type" content="website">
<meta property="og:image" content="{{ app_env('APP_URL') }}/img/brand/logo.png">
<meta property="og:image:secure_url" content="{{ app_env('APP_URL') }}/img/brand/logo.png">
  <meta property="og:image:type" content="image/png">
  <meta property="og:image:width" content="1200">
  <meta property="og:image:height" content="630">
%endsection

%block('content')
%include('challenge.partials.header')
%include('partials.ads')
<section class="container">
  <div class="row">
    <aside class="col-sm-2 hidden-xs" style="margin-top: 10px;">
      %include('layouts.content-sidebar')
    </aside>
    <section class="col-sm-7" style="margin-top: 10px;">
      <ul class="breadcrumb">
        <li><a href="{{ route('index') }}">Home</a></li>
        <li class="active">Challenges</li>
      </ul>
      <div class="row">
        %if ($current_challenge)
        <div class="col-sm-12">
          %include('partials.video', ['url' => $current_challenge->video, 'mode' => 'video'])
          <br>
          <p>
            <span class="text-muted text-bold">{{ $current_challenge->diffused_at->isPast() ? 'Diffusé' : 'Diffusion' }}</span>
            <span>&nbsp;&bull;&nbsp;</span>
            <spam>{{ $current_challenge->diffused_at->diffForHumans() }}</span>
          </p>
          <p>
            {{ $current_challenge->description }}
          </p>
        </div>
        %endif
        <div class="col-sm-12">
          %if (count($challenges) > 0)
          <h3>Retrouvez les challenges précédents</h3>
          %endif
          <div class="row">
            %forelse($challenges as $challenge)
              %include('challenge.partials.challenge', ['challenge' => $challenge, 'size' => 12])
            %empty
              %include('partials.no-data', ['message' => __('challenge.no_data_calendar')])
            %endforelse
          </div>
        </div>
      </div>
    </section>
    <aside class="col-sm-2 col-xs-12 visible-xs" style="margin-top: 10px; margin-bottom: 10px">
      %include('layouts.content-sidebar', ['class' => 'nav-pills'])
    </aside>
    <aside class="col-sm-3" style="margin-top: 10px; z-index: -1">
      %include('partials.about')
    </aside>
  </div>
</section>
%endsection
