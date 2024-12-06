<div class="navbar-min navbar-default navbar-static-top bg-light-blue">
  <div class="container">
    <nav class="navbar-collapse collapse" id="header-navbar">
      <ul class="nav navbar-nav">
        @foreach(\App\Models\Technologie::all() as $technologie)
          <li>
            <a href="{{ route('technologie.index', ['technologie' => $technologie->slug]) }}">{{ ucfirst($technologie->title) }}</a>
          </li>
        @endforeach
      </ul>
    </nav>
  </div>
</div>
