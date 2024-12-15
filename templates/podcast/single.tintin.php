%extends('layouts.app', ['active' => 'podcast'])

%block('title', $podcast->title . " - podcast")

%block('seo')
  %include('partials.seo', [
    'title'         => $podcast->title,
    'description'   => $podcast->description,
    'image'         => $podcast->cover,
    'author'        => $podcast->author->name
  ])
%endblock

%block('description')
  <meta name="description" content="{{ $podcast->title }}">
  <meta name="author" content="{{ $podcast->author->name }}">
%endblock

%block('content')
<div class="jumbotron jumbotron-gray text-left" style="padding-bottom: 10px">
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <h1 style="margin: 0; padding: 0; font-size: 32px; font-weight: 700;">{{ $podcast->title }}</h1>
        <p>{{ $podcast->description }}</p>
      </div>
    </div>
  </div>

  <div class="container video-mobile">
    %if($podcast->isVideo())
      %include('partials.video', ['url' => $podcast->source, 'mode' => 'video'])
    %else
      %include('partials.audio', ['source' => $podcast->source])
    %endif
  </div>
</div>

<section class="container">
  <div class="row">
    <aside class="col-sm-1 hidden-xs" style="margin-top: 10px;">
      %include('partials.social-sidebar', [
        "url" => route('podcast.single', ['podcast' => $podcast->id, 'slug' => $podcast->slug])
      ])
    </aside>
    <section class="col-sx-12 col-sm-8" style="margin-top: 10px;">
      <ul class="breadcrumb">
        <li><a href="{{ route('index') }}">Home</a></li>
        <li><a href="{{ route('podcast') }}">Podcasts</a></li>
        <li class="active">{{ $podcast->title}}</li>
      </ul>
      <div id="reader-content">
        %include('partials.markdown', ['content' => $podcast->content])
      </div>
      <h4 style="margin-top: 10px">
        {{ $podcast->comments()->count() }} {{ __('podcast.comment_title') }}
      </h4>
      <div style="margin-top: 10px;">
        %include('tutorial.comment.form', ['route' => route('comment.make', ['id' => $podcast->id, 'type' => 'podcast'])])
      </div>
      <div style="margin-top: 30px">
        %include('tutorial.partials.comment', ['comments' => $podcast->comments])
      </div>
      <br />
      <div class="row">
        %forelse($podcasts->items() as $podcast)
          %include('podcast.partials.podcast', ['podcast' => $podcast, 'size' => 12])
        %empty
          %include('partials.no-data', ['message' => __('podcast.no_data_calendar')])
        %endforelse
      </div>
      <div class="row no-gutters nogutters">
        <div class="col-sm-12 text-left">
          {{{ $podcasts->links() }}}
        </div>
      </div>
    </section>
    <aside class="col-sm-1 visible-xs" style="margin-top: 10px;">
      %include('partials.social-sidebar', ['class' => 'nav-pills'])
    </aside>
    <aside class="col-sm-3" style="margin-top: 10px;">
      %include('partials.ads-sider')
      <div class="row">
        <div class="col-sm-12">
          <p class="font-weight-bolder">
            {{ __('tutorial.author_title')}}
          </p>
          <p>
            <img src="{{ $podcast->author->avatar }}" class="img-circle img-responsive" alt="Favoris" style="width: 25px; height: 25px; display: inline-block;">
            <strong>{{ $podcast->author->name }}</strong>
            <br>
            <span>{{ $podcast->author->description }}</span>
          </p>
          <hr />
        </div>
      </div>
      %include('partials.about', ['disable_about' => true])
    </aside>
  </div>
</section>
%auth
  %include('tutorial.modal.bookmark', [
    'url' => route('bookmark', ['id' => $podcast->id]),
    'type' => 'podcast',
    'message' => 'Voulez-vous ajouter ce podcast dans votre liste de favoris'
  ])
%endauth
%endblock

%block('script')
  <script type="text/javascript" src="/js/podcast.js"></script>
%endblock
