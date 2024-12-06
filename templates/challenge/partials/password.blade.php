<div class="modal" id="challengePasswordRequire" tabindex="-1">
  <div class="modal-dialog modal-xs" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Token d'authentification</h5>
      </div>
      <form action="{{ route('challenge.token', ['challenge' => $challenge->id]) }}" method="post" id="challengePasswordRequireForm">
        @csrf
        <div class="modal-body">
          <p>Entrez votre token de passage svp ?</p>
          @if (session()->has('error'))
            <div class="bg-danger" style="padding: 10px; margin-bottom: 5px">
              {!! session('error') !!}
            </div>
          @endif
          <div class="form-group">
            <input class="form-control" name="token" placeholder="Toekn de passage" required>
          </div>
        </div>
        <div class="modal-footer">
          <a href="#" style="text-decoration: underline" data-toggle="popover" data-placement="bottom" data-trigger="focus" tabindex="0" data-content="Le token est celui que vous avez reçu par email." class="pull-left">Besoin d'aide ?</a>
          <button type="submit" class="btn btn-sm btn-primary">Valider</button>
        </div>
      </form>
    </div>
  </div>
</div>
