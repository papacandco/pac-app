%guest
  <div class="alert alert-info">
    Connectez-vous pour particiter aux discutions. <a href="{{ route('login') }}?redirect={{ $redirect_to ?? '/' }}" style="text-decoration: underline; color: red !important">Je me connecte !</a>
  </div>
%else
  <div id="comment-form">
    <form action="{{ $route }}" method="POST">
      %csrf
      <div class="row">
        %guest
        <div class="col-sm-6">
          <div class="form-group">
            <input type="text" name="name" class="form-control" placeholder="{{ __('tutorial.form_name') }}"/>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="form-group">
            <input type="email" name="email" class="form-control" placeholder="{{ __('tutorial.form_email') }}"/>
          </div>
        </div>
        %endguest
        <div class="col-sm-12">
          <div class="form-group">
            <div class="text-muted" style="font-size: 12px"><em>* Le formulaire utilise la syntaxe <a href="https://fr.wikipedia.org/wiki/Markdown#Formatage" style="text-decoration: underline;">markdown</a>.</em></div>
            <textarea name="content" class="form-control" style="resize: none;" rows="5" placeholder="{{ __('tutorial.form_description') }}" required></textarea>
          </div>
        </div>
      </div>
      <div class="form-group text-left">
        <button class="btn btn-sm btn-danger">{{ __('tutorial.form_btn') }}</button>
      </div>
    </form>
  </div>
%endguest
