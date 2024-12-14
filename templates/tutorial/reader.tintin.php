%extends('layouts.app', [
  'active' => $form_curriculum ? 'curriculum' : 'tutorial',
])

%block('title', $tutorial->title . ' - tutoriel')

%block('seo')
  %include('partials.seo', [
    'title'         => $tutorial->title,
    'description'   => $tutorial->description,
    'image'         => $tutorial->cover,
    'author'        => $tutorial->author->name
  ])
%endsection

%block('style')
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/editor.md%1.5.0/css/editormd.min.css">
  <link rel="stylesheet" id="highlight-css" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/10.0.3/styles/monokai-sublime.min.css" />
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/10.0.3/highlight.min.js"></script>
  <style type="text/css">
    #share li a:hover {
      background-color: none;
    }
  </style>
%endsection

%block('content')
%include('tutorial.partials.navbar')
%if ($form_curriculum)
  %include('tutorial.partials.description-header')
%endif
%include('tutorial.partials.reader-header')

<section class="container">
  <div class="row">
    <div class="col-sm-1 hidden-xs" style="margin-top: 5px;">
      %include('partials.social-sidebar', [
        'title' => $tutorial->title,
        'url' => route('tutorial.reader', ['slug' => $tutorial->slug, 'id' => $tutorial->id])
      ])
      %if ($tutorial->video)
        <br>
        %include('partials.tags-sidebar', ['taggables' => $tutorial->taggables])
      %endif
    </div>
    <div class="col-sx-12 col-sm-8" style="margin-top: 10px;">
      %if(!(is_null($tutorial->video) || trim($tutorial->video) == '') && !$form_curriculum)
        <div style="padding-top: 0; margin-bottom: 20px;">
          %include('partials.video', ['url' => $tutorial->video, 'mode' => 'video', 'poster' => $tutorial->cover])
        </div>
      %else
        %if (!$form_curriculum)
          <img class="img-responsive" src="{{ $tutorial->cover }}" alt="{{ $tutorial->title }}" style="max-width: auto;">
        %endif
      %endif

      <div class="row">
        <div class="col-sm-12">
          <div class="pull-right">
            %auth
              <a class="hidden-xs" style="position: relative; top: 20px" href="#" title="Ajoutez dans vos favoris" data-toggle="modal" data-target="#add-bookmark-modal">
                <img class="no-img-bg-color" src="/img/misc/tag.svg" alt="Favoris" style="width: 18px; position: relative; top: -1px;">
              </a>
            %else
              <a class="hidden-xs" style="position: relative; top: 20px" href="{{ route('login', ['redirect' => Request::fullUrl()]) }}" title="Ajoutez dans vos favoris">
                <img class="no-img-bg-color" src="/img/misc/tag.svg" alt="Favoris" style="width: 18px; position: relative; top: -1px;">
              </a>
            %endauth
          </div>
          <div style="display: inline-block; position: relative; top: 0px;" id="sub-navbar-info">
            <div class="visible-xs pull-right" style="position: relative; top: 8px; right: -25px;">
              <b>{{ $tutorial->duration }}</b>
            </div>
            <h1>{{ $tutorial->title }}</h1>
            <p class="hidden-xs">{{ ucfirst($tutorial->published_at->diffForHumans()) }} - <b>{{ $tutorial->duration }}</b> de lecture</p>
          </div>
        </div>
      </div>

      <div id="reader-content">
        %include('partials.markdown', [
          'content' => $tutorial->content,
          'escaped' => false
        ])
      </div>

      {## <div id="comment-root" data-route="{{ route('comment.make', ['id' => $tutorial->id, 'type' => 'tutorial' ]) }}"></div> ##}
      <div style="margin-top: 50px; margin-bottom: 20px">
        <h4>
          {{ $tutorial->comments()->count() }} {{ __('tutorial.comment_title') }}
        </h4>
        <div style="margin-top: 10px;">
          %include('tutorial.comment.form', [
            'route' => route('comment.make', [
              'id' => $tutorial->id,
              'type' => 'tutorial'
            ])
          ])
        </div>
        <div style="margin-top: 30px">
          %include('tutorial.partials.comment', [
            'comments' => $tutorial->comments,
            'type' => 'tutorial',
            'target' => $tutorial,
          ])
        </div>
      </div>
    </div>

    <div class="col-xs-12 col-sm-3" style="margin-top: 10px;">
      %include('partials.ads-sider')
      %if ($form_curriculum)
      <div class="row">
        %auth
          %if ($followed)
          <div class="col-sm-12">
            %if (!$ended)
              <button class="btn btn-sm btn-block btn-danger" data-target="#valid-tutorial-progression-modal" data-toggle="modal">
                <i class="fa fa-check"></i> &nbsp; J'ai terminé
              </button>
            %else
              <b class="text-success"><i class="fa fa-check-circle-o"></i>&nbsp;Terminé</b>
              <br/>
            %endif
            <br />
          </div>
          %endif
        %endauth
        <div class="col-sm-12">
          %include('partials.forum', [
            'questions' => $curriculum->lastQuestion(3),
            'title' => $curriculum->title,
            'simple_form' => true,
            'forum_link' => route('forum.single', ['slug' => $curriculum->slug, 'id' => $curriculum->id, 'type' => 'curriculum'])
          ])
        </div>
      </div>
      %endif
      <div class="row">
        <div class="col-sm-12">
          <p class="font-weight-bolder">
            {{ __('tutorial.author_title') }}
          </p>
          <p>
            <img src="{{ $tutorial->author->avatar }}" class="img-circle img-responsive" alt="Favoris" style="width: 40px; height: 40px; display: inline-block; background-color: #eee;">
            <strong>{{ $tutorial->author->name }}</strong>
          </p>
          <p>
            {{ $tutorial->author->description }}
            %if ($tutorial->author->link)
              <br /><a href="{{ $tutorial->author->link }}" target="_blank">{{ $tutorial->author->link }}</a>
            %endif
          </p>
          <hr />
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12">
          %include('partials.about', [
            'disable_about' => true
          ])
        </div>
      </div>
    </div>
    <div class="col-xs-12 col-sm-1 visible-xs" style="margin-bottom: 15px; margin-top: 10px;">
      %include('partials.social-sidebar', ['class' => 'nav-pills'])
      <br>
      %include('partials.tags-sidebar', ['taggables' => $tutorial->taggables, 'class' => 'nav-pills'])
    </div>
  </div>
  %if (count($tutorials) > 0)
  <div class="row" style="margin-top: 10px;">
    <div class="col-sm-12">
      <h3>{{ __('tutorial.latest_title') }}</h3>
      %foreach($tutorials as $tutorial)
        %include('tutorial.partials.thumb', [
          'size' => 4,
          'tutorial' => $tutorial
        ])
      %endforeach
    </div>
  </div>
  %endif
</section>

%auth
  %if ($form_curriculum)
    %include("curriculum.partials.follow-modal")
  %endif
  %include('tutorial.modal.confirm')
  %include('tutorial.modal.bookmark', [
    'url' => route('bookmark', ['id' => $tutorial->id]),
    'type' => 'tutorial',
    'message' => 'Voulez-vous ajouter ce tutoriel dans votre liste de favoris'
  ])
%endif
{## %if ($form_curriculum)
  %include("tutorial.modal.curriculum-sommary")
%endif ##}
%endsection
