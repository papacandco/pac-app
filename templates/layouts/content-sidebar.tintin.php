%if(!isset($hidden_techno))
<p>
  <span class="font-weight-bolder">Technos</span>
</p>
<ul class="nav {{ $class ?? '' }} tech-sidebar">
  %forelse(get_technologies() as $technologie)
    <li {{{ (isset($sidebar_active) ? ($sidebar_active == $technologie->slug ? 'class="tech-sidebar-active"': '') : '') }}}>
      <a href="{{ route('technologie.index', ['technologie' => $technologie->slug]) }}">
        <img src="{{ $technologie->cover }}" class="no-img-bg-color img-circle img-responsive" style="display: inline-block; width: 25px; min-height: 25px;"/>
      </a>
      <ul class="nav {{ $class ?? '' }} tech-sidebar" style="margin-left: 20px">
        %foreach($technologie->technologies as $technologie)
          <li {{{ (isset($sidebar_active) ? ($sidebar_active == $technologie->slug ? 'class="tech-sidebar-active"': '') : '') }}}>
            <a href="{{ route('technologie.index', ['technologie' => $technologie->slug]) }}">
              {{ $technologie->title }}
            </a>
          </li>
        %endforeach
      </ul>
    </li>
  %empty
    <li>Aucune Technologie</li>
  %endforelse
</ul>
%endif
%if(!isset($hidden_author))
{## <br>
<p>
  <span class="font-weight-bolder">Auteurs</span>
</p>
<ul class="nav {{ $class ?? '' }} tech-sidebar" style="margin-bottom: 20px">
  %forelse(get_authors() as $author)
    <li {{{ (isset($author_active) ? ($author_active == $author->id ? 'class="tech-sidebar-active"': '') : '') }}} title="{{ $author->name }}">
      <a href="{{ route($author_product_route ?? 'tutorial') }}?author={{ $author->id }}">
        <img src="{{ gravatar($author->email, 30) }}" class="img-circle img-responsive" style="display: inline-block; width: 25px; min-height: 25px; background-color: #eee"/>&nbsp;{{ ucfirst($author->pseudo) }}
      </a>
    </li>
  %empty
    <li>Aucun Auteur</li>
  %endforelse
</ul> ##}
%endif
