<section class="jumbotron jumbotron-gray text-left" style="padding-top: 10px; padding-bottom: 25px;">
  <header class="container">
    <div class="row">
      <div class="col-sm-2">
        <img class="img-cover pull-right img-responsive"
          src="{{ $technologie->cover }}"
          alt="{{ $technologie->title }}"
          style="width: 120px; height: 120px; position: relative; top: 5px;">
      </div>
      <div class="col-sm-8">
        <h1 style="margin: 0; padding: 0; font-size: 32px; font-weight: 700;">{{ $technologie->title }}</h1>
        <p>{{ $technologie->description }}</p>
      </div>
      <div class="col-sm-2 hidden-xs text-center">
        <h2>{{ count($technologie->tutorials) }}</h2>
        <p>Vidéo(s)</p>
      </div>
      <div class="col-sm-2 text-left visible-xs text">
        <h2 style="display: inline;">{{ count($technologie->tutorials) }}</h2>
        <p style="display: inline; margin-left: 10px">Vidéo(s)</p>
      </div>
    </div>
  </header>
</section>
