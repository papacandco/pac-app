<div class="media paper-item {{ $active ? 'paper-active' : ''}}">
  <div class="media-left">
    <div class="media-object">
      @auth
        <i class="{{ $element->hasProgress(auth()->user()) ? 'fa fa-check-circle' : '' }} {{ $active ? 'text-white' : 'text-success' }}"></i>
      @endauth
      <i class="fa {{ $active ? 'fa-play' : '' }} {{ $active ? 'text-white' : 'text-blue' }}"></i>
    </div>
  </div>
  <div class="media-body">
    <div style="position: relative; top: 4px">
      <strong style="font-weight: normal">
        <a href="{{ route('tutorial.reader', ['slug' => $element->slug, 'id' => $element->id]) }}#pager-{{ $element->id }}" title="{{ $element->title }}">
          {{ str_words($element->title, 5) }}
        </a>
      </strong><br/>
      <span class="text-muted" style="font-size: 12px;">
        {{ $element->duration }} - <span class="text-muted">{{ $element->author->name }}</span>
      </span>
    </div>
  </div>
</div>
