<div class="media shadow-sm rounded" style="padding: 10px;" id="scroll-element-{{ $comment->id }}">
  <div class="media-left">
    <div class="media-object">
      <img class="img-circle img-rounded" src="{{ gravatar($comment->user->email, 60) }}" style="width: 30px; height: 30px;">
    </div>
  </div>

  <div class="media-body">
    <span class="text-muted pull-right" style="font-size: 13px;">
      {{ $comment->created_at->diffForHumans(null) }}
    </span>
    <strong style="position: relative; top: 5px;">{{ $comment->user->name }}</strong>
  </div>
  <div style="margin-top: 10px; font-size: 15px">%include('partials.markdown', ['content' => $comment->content])</div>
  <form action="{{ route('comment.make', ['id' => $question->id, 'type' => 'question']) }}" method="POST" id="question-response-comment-zone-{{ $comment->id }}" style="display: none">
    %csrf
    <textarea style="font-size: 13px" type="text" name="content" class="form-control" placeholder="Entrez votre réponse ici. (Vous pouvez utiliser le markdown)"></textarea>
    <button class="btn btn-primary response-comment" style="margin-top: 10px" data-form-id="question-response-comment-zone-{{ $comment->id }}">Envoyé</button><br/>
    {## <i style="font-size: 10px"><span class="fa fa-info-circle text-info"></span> Appuyer sur la touche <b>Entrer</b> pour valider votre commentaire.</i> ##}
    <input type="hidden" name="comment_id" value="{{ $comment->id }}"/>
  </form>
  <div class="pull-right">
    <a style="font-size: 13px" href="#" data-comment="{{ $comment->id }}" data-state="reply" class="edit-comment">
      <i class="fa fa-edit"></i>&nbsp;{{ __('tutorial.form_response_modify') }}
    </a>
    <a style="font-size: 13px" href="#" data-comment="{{ $comment->id }}" data-state="reply" class="reply-comment">
      &nbsp;<i class="fa fa-reply"></i>&nbsp;{{ __('tutorial.form_response') }}
    </a>
  </div>
</div>
%loop ($comment->comments ?? [] as $cmt)
  <div style="margin-left: 40px; font-size: 13px; padding: 0px; border-bottom: 0.5px dotted #eee">
      <div class="text-muted" style="font-size: 10px;">
        <b>{{ $cmt->created_at->diffForHumans(null) }}</b>
      </div>
      %include('partials.markdown', ['content' => $cmt->content."\n".'**%'.($cmt->user->pseudo ?? $cmt->user->name).'** &nbsp; '])
  </div>
%endloop
