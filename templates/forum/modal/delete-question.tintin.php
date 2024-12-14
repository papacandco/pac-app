<div class="modal" id="delete-question-forum" tabindex="-1">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <form action="{{ route("forum.question.delete") }}" method="post" id="followQuestionForm">
        %csrf
        <div class="modal-body">
          <p>Voulez-vous supprimer cette question ?</p>
        </div>
        <input type="hidden" name="question_id" value="{{ $question->id }}">
        <div class="modal-footer">
          <a href="#" style="text-decoration: underline" data-toggle="popover" data-placement="bottom" data-trigger="focus" tabindex="0" data-content="Tout les commentairs associés seront aussi supprimé" class="pull-left">Besoin d'aide ?</a>
          <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
        </div>
      </form>
    </div>
  </div>
</div>
