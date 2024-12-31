<div class="hidden-xs" style="margin-top: 2px; margin-bottom: 20px; margin-right: 7px">
  <div class="media shadow-sm rounded" style="padding: 5px;" style="border: unset">
    <div class="media-left">
      <div class="media-object" style="padding: 5px;">
        {## <img src="{{ $podcast->cover }}" alt="{{ $podcast->title }}" style="width: 100px; height: 50px; background-color: #eee"> ##}
      </div>
    </div>
    <div class="media-body">
      <span class="text-muted hidden-xs pull-right" style="font-size: 13px; position: relative; right: 8px;">
        <b>{{ $podcast->duration }}</b> de lecture
      </span>
      <strong style="position: relative; top: 5px;">
        <a href="{{ route('podcast.single', ['slug' => str_slug($podcast->title), 'id' => $podcast->id]) }}">
          {{ $podcast->title }}
        </a>
      </strong>
      <p style="margin-top: 10px">
        {{ $podcast->description }}
      </p>
    </div>
  </div>
</div>

<div class="visible-xs" style="margin-top: 2px; margin-bottom: 20px; margin-right: 7px; border-left: 4px solid #144571">
  <div class="media shadow-sm rounded" style="padding: 5px;">
    <div class="media-body">
      <strong style="position: relative; top: 5px;">
        <a href="{{ route('podcast.single', ['slug' => str_slug($podcast->title), 'id' => $podcast->id ]) }}">{{ $podcast->title }}</a>
      </strong>
      <p style="margin-top: 10px">{{ str_words($podcast->description, 12) }}</p>
      <span class="text-muted" style="font-size: 13px;">
        <b>{{ $podcast->duration }}min</b> de lecture
      </span>
    </div>
  </div>
</div>
