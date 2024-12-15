%extends('layouts.app', ['active' => 'forum'])

%block('title', 'Question: '.$question->title)

%block('description')
  <meta name="description" content="{{ $question->title }}">
  <meta name="author" content="{{ $question->author->name }}">
%endblock

%block('seo')
  %include('partials.seo', [
    'title'         => $question->title,
    'description'   => $question->description,
    'image'         => $curriculum->cover ?? config('meta.image'),
    'author'        => $question->author->name
  ])
%endblock

%block('style')
<link rel="stylesheet" id="highlight-css" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/10.0.3/styles/monokai-sublime.min.css" />
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/10.0.3/highlight.min.js"></script>
<style>
  .editormd {
    border: none;
  }
  .question:hover {
    text-decoration: none;
  }
</style>

%include("forum.partials.editor-css")
%endblock

%block('content')
%if($curriculum !== false)
  %include('forum.partials.forum-header')
%endif
%include('partials.ads')
<section class="container">
  <div class="row">
    <div class="col-sm-2 hidden-xs" style="margin-top: 10px;">
      %include('partials.social-sidebar', [
        'title' => $question->title,
        'url' => route('forum.question', ['slug' => $question->slug, 'id' => $question->id])
      ])
      %if(count($taggables = ($question->taggables ?? [])) > 0)
        <br>
        %include('partials.tags-sidebar', ['taggables' => $taggables])
      %endif
    </div>
    <section class="col-sm-8" style="margin-top: 10px;">
      <div class="pull-right" style="position: relative; top: 5px">
        <a href="{{ route('forum.writer') }}{{ $curriculum ? "?curriculum_id=" . $curriculum->id : "" }}" class="btn btn-sm btn-danger">Créer un nouveau sujet</a>
      </div>
      <ul class="breadcrumb">
        <li><a href="{{ route('index') }}">Home</a></li>
        <li><a href="{{ route('forum') }}">Forums</a></li>
        %if($curriculum !== false)
          <li>
            <a href="{{ route('forum.single', ['id' => $curriculum->id, 'slug' => $curriculum->slug]) }}">
              <strong>{{ $curriculum->title }}</strong>
            </a>
          </li>
        %endif
        <li class="active">{{ $question->title }}</li>
      </ul>
      %include('forum.partials.question-header')
      %auth
        %if(auth()->user()->id === $question->user_id)
          <a style="font-size: 13px" href="{{ route("forum.question.update", ["slug" => $question->slug, "id" => $question->id]) }}" class="text-muted">
            <i class="fa fa-edit"></i>&nbsp;{{ __('tutorial.form_response_modify') }}
          </a>&middot;
          <a style="font-size: 13px" href="#" class="text-danger" data-toggle="modal" data-target="#delete-question-forum">
            <i class="fa fa-trash"></i>&nbsp;Supprimer
          </a>
        %endif
      %endif
      <span style="font-size: 13px;" class="text-muted pull-right">Mise à jour {{ $question->updated_at->diffForHumans(null) }}</span>
      {## <div class="pull-right">
        %raw $margin = 0; %endraw
        %loop($contributors as $contributor)
          <img src="{{ gravatar($contributor->user->email, 25)}}" class="img-circle img-responvise"
            style="display: inline-block; position: relative; top: 5px; left: -{{ $margin += 10 }}px"/>
        %endloop
      </div> ##}
      <h4>
        {{ __('forum.join-conversation') }}
      </h4>
      <div class="row">
        %forelse($question->comments as $comment)
          <div class="col-sm-12" style="margin-bottom: 20px">
            %include('forum.partials.comment', [
              'comment' => $comment
            ])
          </div>
        %empty
          %include('partials.no-data', [
            'message' => __('forum.response-no-data', ['name' => '%'.$question->author->name])
          ])
        %endforelse
      </div>
      <div class="row">
        <div class="col-sm-12" style="margin-top: 50px">
          %include('forum.partials.form', [
            'route' => route('forum.question.response', ['slug' => $question->slug, 'id' => $question->id]),
            'redirect_to' => route('forum.question', ['slug' => $question->slug, 'id' => $question->id]),
            'message' => 'Envoyer votre réponse'
          ])
        </div>
      </div>
    </section>
    <aside class="col-sm-3 visible-xs" style="margin-top: 10px; margin-bottom: 10px">
      %include('partials.social-sidebar', [
        'title' => $question->title,
        'url' => route('forum.question', ['slug' => $question->slug, 'id' => $question->id]),
        'class' => 'nav-pills'
      ])
      %if(count($taggables = $question->taggables) > 0)
        <br>
        %include('partials.tags-sidebar', ['taggables' => $taggables, 'class' => 'nav-pills'])
      %endif
      <br>
      %include('layouts.content-sidebar', ['hidden_author' => true, 'class' => 'nav-pills'])
    </aside>
  </div>
</section>
%auth
  %include('forum.modal.follow')
  %if(auth()->user()->id === $question->user_id)
    %include('forum.modal.delete-question')
  %endif
%endauth
%endblock

%block('script')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script type="text/javascript">
    $("#tags_id").select2({ placeholder: "Ajouter des tags" });
    $('.follow-question').click(function (e) {
      $('#followQuestionForm').attr('action', $(this).data('url'));
    });

    $('.reply-comment').click(function () {
      let $replyComment = $(this);
      let id = $replyComment.data('comment');
      if ($replyComment.data('state') == 'reply') {
        $replyComment.data('state', 'cancel');
        $replyComment.html('Annulez');
        $('#question-response-comment-zone-' + id).fadeIn(300);
      } else {
        $('#question-response-comment-zone-' + id).fadeOut(10);
        $replyComment.data('state', 'reply');
        $replyComment.html('Répondre');
      }
    });
  </script>
  %include('partials.editor-script')
%endblock
