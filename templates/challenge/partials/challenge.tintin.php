<div class="col-sm-{{ $size ?? 4 }} col-xs-12">
  <a class="thumbnail shadow border-blue" href="{{ route($challenge->inProgress() ? 'challenge.direct' : 'challenge.single', ['challenge' => $challenge->id, 'slug' => $challenge->slug]) }}">
    <div class="caption">
      <div>
        <strong>
    		  <span>
            {{{ $challenge->diffusionIcon() }}}
          </span>
          <span class="text-blue">#{{ $challenge->id }} </span>
        </strong>
        <span>{{ $challenge->title }}</span>
      </div>
      <div style="font-size: 12px">
        Publié: <b>{{ $challenge->diffused_at->diffForHumans() }}</b>
      </div>
    </div>
  </a>
</div>
