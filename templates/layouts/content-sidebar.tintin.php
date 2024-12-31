%if(!isset($hidden_techno))
<p>
  <span class="font-weight-bolder">Technos</span>
</p>
<ul class="nav {{ $class ?? '' }} tech-sidebar">
  %raw $technologies = get_technologies(); %endraw
  %loop($technologies as $technologie)
    <li {{{ (isset($sidebar_active) ? ($sidebar_active == $technologie->slug ? 'class="tech-sidebar-active"': '') : '') }}}>
      <a href="{{ route('technologie.index', ['technologie' => $technologie->slug]) }}">
        <img src="{{ $technologie->cover }}" class="no-img-bg-color img-circle img-responsive" style="display: inline-block; width: 25px; min-height: 25px;"/>
      </a>
      <ul class="nav {{ $class ?? '' }} tech-sidebar" style="margin-left: 20px">
        %loop($technologie->technologies as $technologie)
          <li {{{ (isset($sidebar_active) ? ($sidebar_active == $technologie->slug ? 'class="tech-sidebar-active"': '') : '') }}}>
            <a href="{{ route('technologie.index', ['technologie' => $technologie->slug]) }}">
              {{ $technologie->title }}
            </a>
          </li>
        %endloop
      </ul>
    </li>
  %endloop
  %if(count($technologies) == 0)
    <li>Aucune Technology</li>
  %endif
</ul>
%endif
