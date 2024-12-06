<p>
  <span class="font-weight-bolder">Tags</span>
</p>
<ul class="nav {{ $class ?? '' }}">
  @foreach($taggables as $taggable)
    <li>
      <span class="label label-danger">
        <a href="{{ route('technologie.index', ['technologie' => $taggable->tag->slug]) }}" class="text-white">{{ strtolower($taggable->tag->title) }}</a>
      </span>
    </li>
  @endforeach
</ul>
