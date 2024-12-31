<div class="row">
  <div class="col-sm-12">
    <div class="media-list">
      %loop($comments as $comment)
        %include('tutorial.comment.comment', ['comment' => $comment])
      %endloop
    </div>
  </div>
</div>
