<section style="margin-bottom: 50px;">
  <header class="media bg-white shadow-sm rounded" style="padding: 10px;">
    <div class="media-left">
      <div class="media-object">
        <img class="img-circle img-rounded" src="{{ gravatar($question->author->email, 60) }}" style="width: 50px; height: 50px; background-color: #eee">
      </div>
    </div>
    <div class="media-body">
      <span class="text-muted pull-right" style="font-size: 13px;">{{ $question->created_at->diffForHumans(null) }}</span>
      <strong style="position: relative; top: 5px;">{{ $question->author->name }}</strong>
      <p style="margin-top: 10px">{{ $question->title }}</p>
    </div>

    <div class="bg-gray" style="position: relative; font-size: 13px;">
      <div class="pull-left text-muted" style="font-weight: bold;">
        {{ $question->numberOfComment() }} <b>Réponse(s)</b>
      </div>
      @if (auth()->check())
        <div class="pull-right">
        @if (!auth()->user()->hasBookmarked($question))
          &nbsp;&nbsp;<a href="#" class="follow-question" data-toggle="modal" data-target="#InfoModal" data-url="{{ route('bookmark', ['id' => $question->id]) }}">Suivre</a>
        @else
          &nbsp;&nbsp;<span class="text-muted">Vous suivez cette question.</span>
        @endif
        </div>
      @endif
      <div class="pull-right">
        @if ($comment = $question->lastComment())
        <span>
          <img class="img-circle" src="{{ gravatar($comment->user->email, 60) }}" style="width: 20px; height: 20px; display: inline-block; background-color: #eee">
        </span>
        <span>&nbsp;{{ $comment->user->name }}</span>&nbsp;&nbsp;&bull;&nbsp;&nbsp;<span class="text-muted">{{ ucfirst($comment->created_at->diffForHumans(null)) }}</span>
        @endif
      </div>
    </div>
  </header>
  @if (!isset($without_content))
  <p style="margin-top: 20px">
    @include('partials.markdown', ['content' => $question->content, 'escaped' => true])
  </p>
  @endif
</section>
