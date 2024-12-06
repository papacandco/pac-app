@extends('layouts.app', ['active' => 'forum'])

@section('title', "Envoyer votre question")

@section('style')
  @include("forum.partials.editor-css")
@endsection

@section('content')
@include('partials.ads')
<section class="container">
  <div class="row">
    <aside class="col-sm-2 hidden-xs" style="margin-top: 10px;">
      @include('layouts.content-sidebar')
    </aside>
    <section class="col-sm-8" style="margin-top: 10px;">
      <ul class="breadcrumb">
        <li><a href="{{ route('index') }}">Home</a></li>
        <li><a href="{{ route('forum') }}">Forums</a></li>
        <li><a href="{{ route('forum.question', ['id' => $question->id, "slug" => $question->slug]) }}">{{ $question->title }}</a></li>
        <li class="active"><strong>Mise à jour de la question</strong></li>
      </ul>
      <p class="alert alert-default">Afin de maximiser vos chances d'obtenir de l'aide, essayez de décrire au mieux votre problème (ne copiez pas des centaines de lignes). Essayez de simplifier votre problème au maximum.</p>
      @isset($question)
        @include('forum.partials.question-header', ['without_content' => true])
      @endisset
      @include('forum.partials.form', [
        'route' => route('forum.question.update', ['id' => $question->id, "slug" => $question->slug]),
        'message' => "Mise à jour de votre question",
        'with_title' => true,
        "id" => $question->id,
        'content' => $question->content,
        'title' => $question->title,
        'tags' => $tags,
        'redirect_to' => route('forum.question', ['id' => $question->id, "slug" => $question->slug]),
      ])
    </section>
    <aside class="col-sm-3 visible-xs" style="margin-top: 10px;">
      @include('layouts.content-sidebar', ['class' => 'nav-pills'])
    </aside>
  </div>
</section>
@endsection

@section('script')
  @include('partials.editor-script')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script>
    $("#tags_id").select2({ placeholder: "Ajouter des tags" });
  </script>
@endsection
