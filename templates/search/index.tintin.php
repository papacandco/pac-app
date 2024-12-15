%extends('layouts.app', ['active' => false])

%block('title', 'Résultat de votre recherche')

%block('seo')
  %include('partials.seo', [
    'title'         => $query,
  ])
%endblock

%block('content')
%include('partials.ads')
<section class="container">
  <div class="row">
    <aside class="col-sm-2 hidden-xs" style="margin-top: 10px;">
      %include('layouts.content-sidebar')
    </aside>
    <div class="col-sm-9 col-xs-12" style="margin-top: 10px;">
      %include('search.partials.filter')
      <h5>{{ count($results) }} {{ __('search.result_message', ['filter' => __('search.filter.'.$filter), 'query' => $query]) }}</h5>
      %forelse($results as $data)
        %include('search.partials.'.$filter, ['data' => $data])
      %empty
        <hr>
        <p><b>Suggestions de recherche:</b></p>
        <ul>
          <li>Vérifie ton orthographe.</li>
          <li>Utiliser moins de mots dans la recherche peut augmenter le nombre de résultats.</li>
          <li>Vous pouvez rechercher n'importe quelle propriété d'un élément, y compris les balises, la description, son contenu, les dates, le créateur et le modificateur.</li>
        </ul>
        %include('partials.no-data', ["message" => "Aucune information trouvée !"])
      %endforelse
    </div>
    <aside class="col-xs-12 visible-xs" style="margin-top: 10px;">
      %include('layouts.content-sidebar', ['class' => 'nav-pills'])
    </aside>
  </div>
</section>
%endblock
