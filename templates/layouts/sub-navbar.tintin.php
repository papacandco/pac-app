<div class="navbar-min navbar-default navbar-static-top bg-light-blue">
  <div class="container">
    <nav class="navbar-collapse collapse" id="header-navbar">
      <ul class="nav navbar-nav">
        %loop(\App\Models\Technology::all() as $technologie)
          <li>
            <a href="{{ route('technologie.index', ['technologie' => $technologie->slug]) }}">{{ ucfirst($technologie->title) }}</a>
          </li>
        %endloop
      </ul>
    </nav>
  </div>
</div>
