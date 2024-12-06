@if (!isset($without_title))
<p>
  <span class="font-weight-bolder">Partagez</span>
</p>
@endif
<ul class="nav {{ $class ?? '' }}">
  @include('partials.social')
</ul>
