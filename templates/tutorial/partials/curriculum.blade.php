@isset($simple)
<div style="margin-top: 2px; margin-bottom: 15px;" class="curriculum-item rounded col-sm-{{ $size ?? "12" }}">
  <div class="media shadow rounded" style="padding: 10px;">
    <div class="media-left">
      <div class="media-object">
        <img src="{{ $curriculum->cover }}" style="width: 80px; height: 80px" alt="{{ $curriculum->title }}">
      </div>
    </div>
    <div class="media-body text-white">
      <strong style="position: relative; top: 5px;">
        <a class="curriculum-link-color" href="{{ route('curriculum.single', ['slug' => $curriculum->slug]) }}">
          {{ $curriculum->title }}
        </a>
      </strong>
      <p style="margin-top: 10px" class="curriculum-text-color">{{ str_words($curriculum->description, 6) }}</p>
    </div>
  </div>
</div>
@else
<div style="margin-top: 2px; margin-bottom: 20px; margin-right: 8px; margin-left: 8px" class="curriculum-item col-sm-{{ $size ?? "12" }}">
  <div class="media rounded shadow-sm">
    <a  class="visible-xs bg-blue" href="{{ route('curriculum.single', ['slug' => $curriculum->slug]) }}" style="display: inline-block">
      <img src="{{ $curriculum->cover }}" style="width: 100%; height: 100%;" alt="{{ $curriculum->title }}">
    </a>
    <div class="media-left hidden-xs">
      <a href="{{ route('curriculum.single', ['slug' => $curriculum->slug]) }}" class="bg-blue" style="display: inline-block">
        <img src="{{ $curriculum->cover }}" style="width: auto; height: 180px;" alt="{{ $curriculum->title }}">
      </a>
    </div>
    <div class="media-body" style="padding: 15px; position: relative;">
      <strong style="position: relative; top: 5px;">
        <a href="{{ route('curriculum.single', ['slug' => $curriculum->slug]) }}">
          {{ $curriculum->title }}
        </a>
      </strong>
      <p style="margin-top: 10px">{{ str_words($curriculum->description, 18) }}</p>
      @auth
        @include("curriculum.partials.progression")
      @endauth
      <span class="text-muted pull-left" style="font-size: 14px; margin-top: 10px">
        {{ ucfirst($curriculum->created_at->diffForHumans(null)) }} &middot; {{ count($curriculum->followers) }} Suivie(s) @auth&middot; Terminé à {{ $progress = $curriculum->computeProgression(auth()->user()) }}%@endauth
      </span>
    </div>
  </div>
</div>
@endif
