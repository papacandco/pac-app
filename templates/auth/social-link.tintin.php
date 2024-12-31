<h3 style="{{ $style ?? '' }}">{{ $title }} Github</h3>
<br />
<div class="form-group">
  <a href="{{ route('soauth', ['provider' => 'github']) }}" class="btn btn-block btn-lg btn-login" style="color: #fff; background-color: #131418">
    <i class="fab fa-github"></i>
  </a>
</div>
