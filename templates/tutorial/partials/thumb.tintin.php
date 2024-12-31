%raw
  $pager = !is_null($tutorial->graph_id) ? '#pager-' . $tutorial->id : '';
%endraw
<div class="col-sm-{{ $size ?? 4 }} col-xs-12 tutorial-item" style="padding-left: 5px; padding-right: 5px; padding-bottom: 0px; margin-bottom: 10px">
  <div class="thumbnail bg-white visible-xs rounded" style="overflow: hidden !important; cursor: default; margin: 10px;">
    <a class="bg-blue" title="{{ $tutorial->title }}" href="{{{ route('tutorial.reader', ['slug' => $tutorial->slug, 'id' => $tutorial->id]) }}}" style="display: block; min-height: 150px">
      <img src="{{ $tutorial->cover }}" class="img-responsive" alt="{{ $tutorial->title }}">
    </a>
    <div class="caption">
      <div class="pull-right">
        <a href="{{{ route('technologie.index', ['technologie' => $tutorial->technologie->slug]) }}}">
          <img src="{{ $tutorial->technologie->cover }}" class="img-circle img-responsive" style="width: 22px;">
        </a>
      </div>
      <div class="text-left">
        <strong>
          <a title="{{ $tutorial->title }}" href="{{{ route('tutorial.reader', ['slug' => $tutorial->slug, 'id' => $tutorial->id]) }}}{{ $pager }}">
            {{ str_limit($tutorial->title) }}
          </a>
        </strong>
      </div>
      <p class="text-muted" style="font-size: 11px">
        Durée: <b class="text-info">{{ $tutorial->duration }}</b> &nbsp; Par <span class="text-muted">{{ $tutorial->author->name }}</span>
      </p>
    </div>
  </div>

  <div class="thumbnail bg-white hidden-xs rounded" style="overflow: hidden; cursor: default; min-height: 420px; max-height: 450px;">
    <a class="bg-blue" title="{{ $tutorial->title }}" href="{{{ route('tutorial.reader', ['slug' => $tutorial->slug, 'id' => $tutorial->id]) }}}{{ $pager }}" style="display: block; min-height: 150px">
      <img src="{{ $tutorial->cover }}" class="img-responsive" alt="{{ $tutorial->title }}">
    </a>
    <div class="caption">
      <div class="text-left">
        <strong>
          <a title="{{ $tutorial->title }}" href="{{{ route('tutorial.reader', ['slug' => $tutorial->slug, 'id' => $tutorial->id]) }}}{{ $pager }}">
            {{ $tutorial->title }}
          </a>
        </strong>
      </div>
      <p class="text-muted" style="font-size: 15px;">
        Durée: <b class="text-info">{{ $tutorial->duration }}</b>
      </p>
      <p style="font-size: 1.4rem;" title="{{ $tutorial->description }}">
        {{{ str_words($tutorial->description, 14) }}}
      </p>
    </div>
  </div>
  <a class="hidden-xs" href="{{{ route('technologie.index', ['technologie' => $tutorial->technologie->slug]) }}}">
    <span class="course-metadata clearfix">
      <span class="course-metadata__technologie"> <img src="{{ $tutorial->technologie->cover }}" class="img-responsive pull-left" style="width: 10px; position: relative; left: -2px; top: 1px; margin-right: 3px;"> {{ $tutorial->technologie->title }}</span>
    </span>
  </a>
</div>
