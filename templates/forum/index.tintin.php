%extends('layouts.app', ['active' => 'forum'])

%block('title', 'Forum')

%block('description')
<meta name="description" content="Ici, Vous pouvez poser votre question relative à chaque thématique">
<meta name="author" content="Franck DAKIA">
%endblock

%block('seo')
  %include('partials.seo', [
    'title'         => "Forum",
    'description'   => "Ici, Vous pouvez poser votre question relative à chaque thématique",
  ])
%endblock

%block('content')
{## %include('forum.partials.header') ##}
%isset($curriculum)
  %include('forum.partials.forum-header')
%endisset
%include('partials.ads')
<section class="container">
  <div class="row">
    <aside class="col-sm-2 hidden-xs" style="margin-top: 10px;">
      %include('layouts.content-sidebar')
    </aside>
    <section class="col-sm-8 col-xs-12" style="margin-top: 10px;">
      <div class="row no-gutters nogutters">
        <div class="col-sm-12">
          <div class="pull-right" style="position: relative; top: 5px">
            <a href="{{ route('forum.writer') }}{{ isset($curriculum) ? "?curriculum_id=" . $curriculum->id : "" }}" class="btn btn-sm btn-danger">Créer un nouveau sujet</a>
          </div>
          <ul class="breadcrumb">
            <li><a href="{{ route('index') }}">Home</a></li>
            <li class="active">Forums</li>
          </ul>
        </div>
      </div>
      <div class="row no-gutters nogutters">
        %forelse($questions->items() as $question)
          %include('forum.partials.question', [
            'question' => $question,
            'type' => 'forum'
          ])
        %empty
         %include('partials.no-data', [
            'message' => __('forum.question-no-data')
            ])
        %endforelse
      </div>
      <div class="row no-gutters nogutters">
        <div class="col-sm-12 text-left">
          {{{ $questions->links() }}}
        </div>
      </div>
    </section>
    <aside class="col-sm-3 col-xs-12 visible-xs" style="margin-top: 10px; margin-bottom: 10px">
      %include('layouts.content-sidebar', ['class' => 'nav-pills'])
    </aside>
  </div>
</section>
%endblock
