<section class="jumbotron jumbotron-gray text-left" id="forum-curriculum-{{ $curriculum->id }}" style="padding-top: 10px; padding-bottom: 25px;">
  <header class="container">
    <div class="pull-right">
      <a href="#" id="close-header" class="text-white" data-parent="{{ $curriculum->id }}" style="text-decoration: none;">&times;</a>
    </div>
    <div class="row">
      <div class="col-sm-3">
        <img class="img-responsive"
          src="{{ $curriculum->cover }}"
          alt="{{ $curriculum->title }}"
          style="width: auto; position: relative; top: 0px;">
      </div>
      <div class="col-sm-8">
        <h1 style="margin: 0; padding: 0; font-size: 32px; font-weight: 700;">{{ $curriculum->title }}</h1>
        <p>{{ $curriculum->description }}</p>
        <span class="text-muted">Forum de formation</span>
      </div>
      <div class="col-sm-1 hidden-xs text-center">
        <h2>{{ count($curriculum->questions) }}</h2>
        <p>Question(s)</p>
      </div>
      <div class="col-sm-2 text-left visible-xs text">
        <h2 style="display: inline; margin: 0; padding: 0">{{ count($curriculum->questions) }}</h2>
        <p style="display: inline; margin-left: 10px">Question(s)</p>
      </div>
    </div>
  </header>
</section>
