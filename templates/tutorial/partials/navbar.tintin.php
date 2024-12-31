<div id="sub-navbar" class="shadow-sm"
  style="position: fixed; left: 0; right: 0; top: 0; height: 50px; z-index: 1000; display: none; overflow: hidden;">
  <div class="container">
    <div class="row">
      <div class="col-sm-9 col-xs-12">
        <div style="display: inline-block; position: relative; top: 4px;" id="sub-navbar-info">
          <img src="{{ $tutorial->cover }}" class="img-circle img-responsive" alt="Favoris"
            style="width: 40px; height: 40px; display: inline-block;">
          <strong>{{ $tutorial->title }}</strong>
          <span class="hidden-xs"> - Ajouté {{ $tutorial->created_at->diffForHumans() }} - <b>{{ $tutorial->duration }}</b> de lecture</span>
        </div>
      </div>
      <div class="col-sm-3 hidden-xs" style="position: relative; top: 6px">
        <ul class="nav nav-pills nav-link" style="display: inline-block;">
          %include('tutorial.partials.social-link')
          %include('partials.social', ["url" => route('tutorial.reader', ['slug' => $tutorial->slug, 'id' => $tutorial->id])])
        </ul>
      </div>
    </div>
  </div>
</div>
