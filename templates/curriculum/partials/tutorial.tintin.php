<div class="hidden-xs" style="margin-top: 2px; margin-bottom: 20px; margin-right: 7px">
  <div class="media shadow-sm rounded" style="padding: 5px;" style="border: unset">
    <div class="media-left">
      <div class="media-object" style="padding: 5px;">
        <i class="fa fa-play text-{{ auth()->check() && $followed && $tutorial->hasProgress(auth()->user()) ? "success" : "white" }}"></i>
        {## <img src="{{ $tutorial->cover }}" alt="{{ $tutorial->title }}" style="width: 150px; height: 100px"> ##}
      </div>
    </div>
    <div class="media-body">
      <span class="text-muted hidden-xs pull-right" style="font-size: 13px; position: relative; right: 8px;">
        <b>{{ $tutorial->duration }}</b> de lecture
      </span>
      <strong style="position: relative; top: 5px;">
        <a href="{{ route('tutorial.reader', [
          'slug' => $tutorial->slug,
          'id' => $tutorial->id
          ]) }}#pager-{{ $tutorial->id }}">
          {{ $tutorial->title }}
        </a>
      </strong>
      <p style="margin-top: 10px">
        {## {{ str_words($tutorial->description, 10) }} ##}
      </p>
    </div>
  </div>
</div>

<div class="visible-xs" style="margin-top: 2px; margin-bottom: 20px; margin-right: 7px; border-left: 4px solid #144571">
  <div class="media shadow-sm rounded" style="padding: 5px;">
    <div class="media-body">
      <strong style="position: relative; top: 5px;">
        <a href="{{ route('tutorial.reader', [
          'slug' => $tutorial->slug,
          'id' => $tutorial->id
          ]) }}#pager-{{ $tutorial->id }}">{{ $tutorial->title }}</a>
      </strong>
      <p style="margin-top: 10px">{{ str_words($tutorial->description, 12) }}</p>
      <span class="text-muted" style="font-size: 13px;">
        <b>{{ $tutorial->duration }}</b> de lecture
      </span>
    </div>
  </div>
</div>
