<div class="col-sm-12" id="scroll-element-{{ $question->id }}" style="{{ $style ?? "" }}">
  <div style="margin-top: 2px; margin-bottom: 10px;" class="question-item shadow-sm">
    <a href="{{ route('forum.question', ['slug' => $question->slug, 'id' => $question->id]) }}" class="question" style="cursor: pointer;">
      <div class="media bg-white rounded" style="padding: 10px;">
        <div class="media-left">
          <div class="media-object">
            <img class="img-circle" src="{{ gravatar($question?->author?->email ?? "invalide%email.com", 60) }}" style="width: 50px; height: 50px; background-color: #eee">
          </div>
        </div>
        <div class="media-body">
          <span class="text-muted pull-right" style="font-size: 13px;">
            {{ ucfirst($question->created_at->diffForHumans(null)) }}
          </span>
          <strong style="position: relative; top: 5px;">{{ $question->author->name }}</strong>
          <p style="margin-top: 5px">{{ $question->title }}</p>
        </div>
        <div class="bg-gray" style="position: relative; font-size: 12px; background-color: #9999">
          <div class="pull-left text-muted">
            {{ count($question->comments) . ' Réponse(s)' }}
            %foreach($question->taggables as $taggable)
              <a href="{{ route('forum', ['tag' => $taggable->tag_id]) }}" class="text-info "><strong>#{{ strtolower($taggable->tag->title) }}</strong></a>
            %endforeach
          </div>
          <div class="pull-right">
            %if ($comment = $question->lastComment())
            <span>
              <i class="fa fa-reply"></i>&nbsp;<img class="img-circle" src="{{ gravatar($comment->user->email, 60) }}" style="width: 20px; height: 20px; display: inline-block; background-color: #eee">
            </span>
            <span>&nbsp;{{ $comment->user->name }}</span>&nbsp;&nbsp;&bull;&nbsp;&nbsp;<span class="text-muted">{{ ucfirst($comment->created_at->diffForHumans(null)) }}</span>
            %else
              <span class="text-muted">Aucune réponse</span>
            %endif
          </div>
        </div>
      </div>
    </a>
  </div>
</div>
