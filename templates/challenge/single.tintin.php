%extends('layouts.app', ['active' => 'challenge'])

%block('title', $challenge->title)

%block('description')
<meta name="description" content="{{ $challenge->title }}">
<meta name="author" content="{{ $challenge->author->name }}">
%endsection

%block('twitter')
  <meta property="twitter:card" name="twitter:card" content="summary_large_image">
  <meta property="twitter:site" name="twitter:site" content="%franck_dakia">
  <meta property="twitter:creator" name="twitter:creator" content="%franck_dakia">
  <meta property="twitter:title" name="twitter:title" content="{{ $challenge->title }}">
  <meta property="twitter:description" name="twitter:description" content="{{ $challenge->description }}">
  <meta property="twitter:image:src" name="twitter:image:src" content="{{ $challenge->cover }}">
%endsection

%block('facebook')
  <meta name="og:author" property="og:author" content="{{ app_env('APP_URL') }}">
  <meta name="og:url" property="og:url" content="{{ route($challenge->inProgress() ? 'challenge.direct' : 'challenge.single', ['challenge' => $challenge->id, 'slug' => $challenge->slug]) }}">
  <meta name="og:title" property="og:title" content="{{ $challenge->title }}">
  <meta name="og:description" property="og:description" content="{{ $challenge->description }}">
  <meta name="og:type" property="og:type" content="profile">
  <meta name="og:site_name" property="og:site_name" content="{{ app_env('APP_NAME') }}" />
  <meta name="og:image" property="og:image" content="{{ $challenge->cover }}">
  <meta name="og:username" property="profile:username" content="{{ app_env('APP_NAME') }}" />
%endsection

%include('challenge.partials.social-media')

%block('content')
<div class="jumbotron bg-primary video-mobile" style="padding-bottom: 30px">
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <h1>{{ $challenge->title }}</h1>
        %if ($challenge->isPending())
          <h5 class="text-muted">{{ $challenge->diffused_at->isPast() ? 'Diffusé' : 'Diffusion' }} {{ $challenge->diffused_at->diffForHumans() }}</h5>
        %endif
      </div>
    </div>
  </div>

  %if ($challenge->isDiffused())
    <div class="container video-mobile">
      %include('partials.video', ['url' => $challenge->video, 'mode' => 'video'])
    </div>
  %endif
</div>

<section class="container">
  <div class="row">
    <aside class="col-sm-1 hidden-xs" style="margin-top: 10px;">
      %include('partials.social-sidebar')
    </aside>
    <section class="col-sx-12 col-sm-8" style="margin-top: 10px;">
      <ul class="breadcrumb">
        <li><a href="{{ route('index') }}">Home</a></li>
        <li><a href="{{ route('challenge') }}">Challenges</a></li>
        <li class="active">{{ $challenge->title}}</li>
      </ul>
      <div id="reader-content">
        %include('partials.markdown', ['content' => $challenge->description])
      </div>
      <h4 style="padding: 10px">
        {{ $challenge->messages()->count() }} {{ __('challenge.comment_title') }}
      </h4>
      <div style="margin-top: 10px; padding: 10px">
        %include('tutorial.comment.form', ['route' => route('comment.make', ['id' => $challenge->id, 'type' => 'challenge'])])
      </div>
      <div style="margin-top: 30px">
        %include('tutorial.partials.comment', ['comments' => $challenge->messages])
      </div>
    </section>
    <aside class="col-sm-1 visible-xs" style="margin-top: 10px;">
      %include('partials.social-sidebar', ['class' => 'nav-pills'])
    </aside>
    <aside class="col-sm-3" style="margin-top: 10px;">
      %include('partials.ads-sider')
      <div class="row">
        <div class="col-sm-12">
          <p class="text-muted">
            {{ __('tutorial.author_title')}}
          </p>
          <p>
            <img src="{{ $challenge->author->avatar }}" class="img-circle img-responsive" alt="Favoris" style="width: 25px; height: 25px; display: inline-block;">
            <strong>{{ $challenge->author->name }}</strong>
            <br>
            <span>{{ $challenge->author->description }}</span>
          </p>
        </div>
      </div>
      %include('partials.about', [
        'disable_about' => true
      ])
    </aside>
  </div>
</section>
%endsection
