<div class="modal fade" id="valid-tutorial-progression-modal" tabindex="-1">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="fa fa-check text-muted"></i>&nbsp;Confirmer</h5>
      </div>
      <form action="{{ route('tutorial.progress', ['id' => $tutorial->id]) }}" method="post">
        @csrf
        <div class="modal-body">
          <p>Vous confirmez avoir terminé cette tutoriel</p>
          <input type="hidden" name="type" value="tutorial">
        </div>
        <div class="modal-footer">
          <a href="#" style="text-decoration: underline" data-toggle="popover" data-placement="bottom" data-trigger="focus" tabindex="0" data-content="Les bookmarks vous permet de suivre les activités sur ce tutoriel et l'ajouter dans votre profil au cas si vous aimeriez le trouver facilement." class="pull-left">Besoin d'aide ?</a>
          <button type="submit" class="btn btn-sm btn-danger">TERMINER</button>
        </div>
      </form>
    </div>
  </div>
</div>
