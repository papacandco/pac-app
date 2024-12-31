<div class="media shadow-sm rounded" style="padding: 10px;" id="scroll-element-{{ $comment->id }}">
  %include('tutorial.comment.content', ['comment' => $comment])
</div>

%loop ($comment->comments ?? [] as $child)
  <div style="margin-left: 20px; margin-top: 5px;">
    %include('tutorial.comment.comment', ['comment' => $child])
  </div>
%endloop
