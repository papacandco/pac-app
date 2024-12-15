%extends('layouts.app', ['active' => 'forum'])

%block('title', "Envoyer votre question")

%block('style')
  %include("forum.partials.editor-css")
%endblock

%block('content')
%isset($curriculum)
  %include('forum.partials.forum-header')
%endisset
%include('partials.ads')
<section class="container">
  <div class="row">
    <aside class="col-sm-2 hidden-xs" style="margin-top: 10px;">
      %include('layouts.content-sidebar')
    </aside>
    <section class="col-sm-8" style="margin-top: 10px;">
      <ul class="breadcrumb">
        <li><a href="{{ route('index') }}">Home</a></li>
        <li><a href="{{ route('forum') }}">Forums</a></li>
        <li class="active"><strong>Créer un nouveau sujet</strong></li>
      </ul>
      <p>Afin de maximiser vos chances d'obtenir de l'aide, essayez de décrire au mieux votre problème (ne copiez pas des centaines de lignes). Essayez de simplifier votre problème au maximum.</p>
      <br>
      %include('forum.partials.form', [
        'route' => isset($curriculum) ? route('forum.curriculum.writer', ['id' => $curriculum->id]) : route('forum.writer'),
        'message' => 'Envoyer votre question',
        'with_title' => true,
        'redirect_to' => route('forum.writer'),
      ])
    </section>
    <aside class="col-sm-3 visible-xs" style="margin-top: 10px;">
      %include('layouts.content-sidebar', ['class' => 'nav-pills'])
    </aside>
  </div>
</section>
%endblock

%block('script')
  %include('partials.editor-script')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script>
    $("#tags_id").select2({ placeholder: "Ajouter des tags" });
  </script>
%endblock
