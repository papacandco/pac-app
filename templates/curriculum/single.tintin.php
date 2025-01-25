%extends('layouts.app', ['active' => 'curriculum'])

%block('title', $curriculum->title . ' - formation')

%block('seo')
  %include('partials.seo', [ 'title' => $curriculum->title, 'description' => $curriculum->description, 'image' => $curriculum->cover ?? config('meta.image')])
%endblock

%block('content')
  %include('curriculum.partials.curriculum-header')
  <section class="container">
    <div class="row">
      <section class="col-sm-9">
        <div class="video-mobile">
          %include('partials.video', ['url' => $curriculum->video, 'mode' => 'video'])
        </div>
        <div class="row">
          <div class="col-sm-6">
            %include('partials.social-sidebar', ['without_title' => true, 'class' => 'nav-pills', 'title' => $curriculum->title, 'url' => route('curriculum.single', ['slug' => $curriculum->slug])])
          </div>
          %if($curriculum->video)
            <div class="col-sm-6">
              %include('partials.tags-sidebar', ['without_title' => true, 'taggables' => $curriculum->taggables ?? [], 'class' => 'nav-pills pull-right'])
            </div>
          %endif
        </div>
        <div class="row" style="margin-top: 18px;">
          %if(strlen($curriculum->long_description) > 0)
          <div class="col-sm-12 text-justify" style="padding: 2px">
            {{{ $curriculum->long_description }}}
          </div>
          %endif
          <div class="col-sm-12" style="margin-top: 10px; padding: 2px">
            %loop($curriculum->sections as $key => $section)
              <h3><span class="font-weight-bold">Chapitre {{ $key + 1 }} </span> - {{ $section->title }}</h3>
              <p class="text-muted">{{ $section->description }}</p>
              %loop($section->tutorials as $tutorial)
                %include('curriculum.partials.tutorial', ['tutorial' => $tutorial, 'curriculum' => $curriculum, 'size' => 6])
              %endloop
            %endloop
            %if($curriculum->sections()->count() == 0)
              %include('partials.no-data', ['message' => __('tutorial.no_data')])
            %endif
          </div>
        </div>
        %if($curriculum->with_forum)
          <hr />
          <div class="row" style="margin-top: 18px;">
            %include('partials.forum', [ 'questions' => $curriculum->lastQuestion(5), 'title' => $curriculum->title, "style" => "padding-left: 5px; font-size: 14px;", 'forum_link' => route('forum.single', ['slug' => $curriculum->slug, 'id' => $curriculum->id])])
          </div>
        %endif
      </section>
      <aside class="col-xs-12 col-sm-3" style="margin-top: 15px;">
        %auth
          %if($followed)
            <a class="btn btn-danger btn-block" href="{{ route('tutorial.reader', ['slug' => $tutorial->slug, 'id' => $tutorial->id]) }}#pager-{{ $tutorial->id }}">
              Continuer la formation
            </a>
          %else
            <a class="btn btn-danger" data-toggle="modal" data-target="#follow-curriculum-modal">
              Demarrer cette formation
            </a>
          %endif
        %else
          <a class="btn btn-danger" href="{{ route("login") }}?redirect={{ route('curriculum.single', ['slug' => $curriculum->slug]) }}" class="text-white">Demarrer cette formation</a>
        %endauth
        %include('partials.ads-sider')
        <div class="row">
          <div class="col-sm-12" style="margin-top: 15px;">
            <p class="font-weight-bolder">
              {{ __('tutorial.author_title') }}
            </p>
            <p>
              <img src="{{ gravatar($tutorial->author->avatar) }}" class="img-circle img-responsive" alt="Favoris" style="width: 40px; height: 40px; display: inline-block; background-color: #eee;">
              <strong>{{ $tutorial->author->name }}</strong>
            </p>
            <p>
              {{ $tutorial->author->description }}
              %if($tutorial->author->link)
                <br /><a href="{{ $tutorial->author->link }}" target="_blank">{{ $tutorial->author->link }}</a>
              %endif
            </p>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12" style="margin-top: 15px;">
            %include('partials.about', ['disable_about' => true])
          </div>
        </div>
      </aside>
    </div>
  </section>
%endblock
