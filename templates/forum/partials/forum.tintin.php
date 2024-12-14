<?php
$question = $forum->questions[0] ?? null;
?>
<div class="col-sm-6" style="margin-top: 2px; margin-bottom: 20px;">
  <div class="media shadow-sm" style="padding: 10px; min-height: 105px; max-height: 105px" id="scroll-element-{{ $forum->id }}">
    <div class="media-body">
      <span class="text-muted pull-right" style="font-size: 13px;">
        {{ count($forum->questions) }} <b>Q</b>
      </span>
      <a href="{{ route('forum.single', ['slug' => $forum->slug]) }}?type={{ $type ?? 'technologie' }}">
        <strong style="position: relative; top: 5px;">
          {{ $forum->title }}
        </strong>
      </a>
      <p style="margin-top: 10px; font-size: 12px;">
        %if (!is_null($question))
        <a class="text-muted" href="{{ route('forum.question', ['slug' => $forum->slug, 'question' => $question->slug, 'id' => $question->id]) }}"
          title="{{ $question->title }}">
          <img class="img-circle" src="{{ gravatar($question->author->email, 60) }}" style="width: 20px; height: 20px; background-color: #eee"> {{ str_limit($question->title, 25) }}
          <span class="text-muted pull-right" style="font-size: 10px;">
            {{ ucfirst($question->created_at->diffForHumans(null)) }}
          </span>
        </a>
        %else
        <span class="text-muted" style="font-size: 15px;" title="Aucune question. Soyez le premier a posté votre préocupation !">
          Soyez le premier a posté votre préocupation !
        </span>
        %endif
      </p>
    </div>
  </div>
</div>
