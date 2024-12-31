<div class="media-left">
  <div class="media-object">
    <img class="img-circle" src="{{ gravatar($comment->user->email, 60) }}" style="width: 40px; height: 40px; background-color: #eee">
  </div>
</div>
<div class="media-body" style="font-size: 15px;">
  <span class="text-muted pull-right" style="font-size: 13px;">
    {{ $comment->created_at->diffForHumans(null) }}
  </span>
  <strong>{{ ucwords($comment->user->name) }}</strong>
  <p style="margin-top: 10px">{{{ $comment->content }}}</p>
  <div class="pull-right">
    %if(auth()->check() && $comment->user_id == auth()->id())
      <a href="#"
        style="font-size: 13px;"
        data-comment="{{ $comment->id }}"
        data-commentable="{{ $comment->commentable->id }}"
        %isset($admin)
          class="update-comment-admin" data-target="#addComment" data-toggle="modal"
          data-url="{{ route('admin.comment.make', [
              'id' => $target->id,
              'type' => $type
            ]) }}"
        %else
          class="update-comment"
        %endif
        >
        <i class="fa fa-edit"></i>&nbsp;{{ __('tutorial.form_response_modify') }}
      </a>
      &nbsp;
    %endauth
    <a href="#"
      style="font-size: 13px;"
      data-comment="{{ $comment->id }}"
      data-commentable="{{ $comment->commentable->id }}"
      %isset($admin)
        class="reply-comment-admin" data-target="#reply-comment-modal" data-toggle="modal"
        data-url="{{ route('admin.comment.make', [
            'id' => $target->id,
            'type' => $type
          ]) }}"
      %else
        class="reply-comment"
      %endif
      >
      &nbsp;<i class="fa fa-reply"></i>&nbsp;{{ __('tutorial.form_response') }}
    </a>
  </div>
</div>
<div id="comment-form-conatiner-{{ $comment->id }}"></div>
