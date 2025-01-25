<p>
  <strong class="font-weight-bolder">
    {{ __('about.comment.title') }}
  </strong>
</p>

%raw
  $commends = get_latest_comment();
%endraw

%loop($commends as $comment)
  %jump(is_null($comment->commentable) || is_null($comment->user))
  <p class="shadow-sm" style="padding: 10px; word-wrap: break-word; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
    <img src="{{ gravatar($comment->user->email) }}" class="img-circle img-responsive" style="width: 25px; display: inline-block; background-color: #eee">
    {{ str_words($comment->content, 50, '...') }} <br>
    <span class="text-muted">
      %if($comment->isForTutorial())
      <a href="{{ route('tutorial.reader', ['slug' => $comment->commentable->slug, 'id' => $comment->commentable->id ]) }}#c-{{ $comment->id }}" style="text-decoration: underline;">
        {{ $comment->commentable->title }}
      </a>
      %elseif($comment->isForChallenge())
      <a href="{{ route('challenge.single', [ 'slug' => $comment->commentable->slug, 'challenge' => $comment->commentable->id ]) }}#c-{{ $comment->id }}" style="text-decoration: underline;">
        {{ $comment->commentable->title }}
      </a>
      %elseif($comment->isForQuestion())
      <a href="{{ route('forum.question', ['slug' => $comment->commentable->slug, 'id' => $comment->commentable->id ]) }}#c-{{ $comment->id }}" style="text-decoration: underline;">
        {{ $comment->commentable->title }}
      </a>
      %elseif($comment->isForPodcast())
      <a href="{{ route('podcast.single', ['slug' => $comment->commentable->slug, 'podcast' => $comment->commentable->id ]) }}#c-{{ $comment->id }}"
        style="text-decoration: underline;">
        {{ $comment->commentable->title }}
      </a>
      %endif
    </span>
  </p>
%endloop

%if(count($commends) === 0)
  <p style="word-wrap: break-word; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
    {{ __('about.comment.no_data') }}
  </p>
%endif
