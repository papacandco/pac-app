<div class="modal fade" id="add-bookmark-modal" tabindex="-1">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="fa fa-bookmark-o text-muted"></i>&nbsp;Bookmark</h5>
      </div>
      <form action="{{ $url }}" method="post" id="challenge-password-require-form">
        @csrf
        <div class="modal-body">
          <p>{{ $message }}</p>
          <input type="hidden" name="type" value="{{ $type }}">
        </div>
        <div class="modal-footer">
          <a href="#" style="text-decoration: underline" data-toggle="popover" data-placement="bottom" data-trigger="focus" tabindex="0" data-content="Les bookmarks vous permet de suivre les activités sur ce tutoriel et l'ajouter dans votre profil au cas où vous aimeriez le trouver facilement." class="pull-left">Besoin d'aide ?</a>
          <button type="submit" class="btn btn-sm btn-danger">OUI</button>
        </div>
      </form>
    </div>
  </div>
</div>
