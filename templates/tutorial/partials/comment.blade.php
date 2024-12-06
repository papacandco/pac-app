<div class="row">
  <div class="col-sm-12">
    <div class="media-list">
      @foreach($comments as $comment)
        @include('tutorial.comment.comment')
      @endforeach
    </div>
  </div>
</div>
