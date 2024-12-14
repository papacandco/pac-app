<div class="modal" id="InfoModal" tabindex="-1">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <form action="#" method="post" id="followQuestionForm">
        %csrf
        <div class="modal-body">
          <p>Voulez-vous suivre cette question ?</p>
        </div>
        <input type="hidden" name="type" value="question">
        <div class="modal-footer">
          <a href="#" style="text-decoration: underline" data-toggle="popover" data-placement="bottom" data-trigger="focus" tabindex="0" data-content="Lorsque vous suivez une question. Vous serez informer de tous les activités autour de cette question?" class="pull-left">Besoin d'aide ?</a>
          <button type="submit" class="btn btn-sm btn-primary">Suivre la question</button>
        </div>
      </form>
    </div>
  </div>
</div>
