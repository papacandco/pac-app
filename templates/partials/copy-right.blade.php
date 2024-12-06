<div class="row text-center" style="margin-bottom: 0;">
  <div class="col-sm-12 col-xs-12">
    <p class="{{ $class ?? 'text-muted' }}" style="margin-top: 10px">
      &copy; {{ date('Y') }} Créé et maintenu avec 💙 par <a href="https://papacandcohq.com" class="{{ $class ?? '' }}" style="text-decoration: underline;"><img src="/img/brand/papacandco.jpg" width="20px" class="img-circle img-responsive" style="display: inline-block"/> Papac & Co</a> &middot; {!! __('vendor.copy-right', ['url' => $route ?? '#', 'class' => $class ?? '']) !!} &middot; <a class="{{ $class ?? '' }}" href="https://github.com/papac"><i class="fab fa-github"></i> GitHub</a>
    </p>
  </div>
</div>
