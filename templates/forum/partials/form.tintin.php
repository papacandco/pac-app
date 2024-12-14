%guest
<div class="alert alert-info">
  Connectez-vous pour particiter aux discutions. <a class="text-danger" href="{{ route('login') }}?redirect={{ $redirect_to ?? '/' }}" style="text-decoration: underline; color: red !important">je me connecte !</a>
</div>
%else
<form action="{{ $route }}" method="POST" enctype="multipart/form-data">
  %csrf
  %isset($id)
    <input type="hidden" name="id" value="{{ $id }}">
  %endisset
  <div class="row">
    %isset($with_title)
      <div class="col-sm-12">
        <div class="form-group">
          <label class="control-label">Titre de votre question</label>
          <input type="text" class="form-control" name="title" placeholder="Donnez un titre a votre question" value="{{ $title ?? "" }}" required>
        </div>
      </div>
      <div class="col-sm-12">
        <label class="control-label">Tags</label>
        <div class="form-group select">
          <select id="tags_id" name="tags_id[]" class="form-control" style="color: #000 !important" multiple required>
            %foreach(get_technologies() as $technologie)
              <optgroup label="{{ $technologie->title }}">
                <option value="{{ $technologie->id }}" {{ isset($tags) && in_array($technologie->id, $tags) ? "selected" : "" }}>{{ $technologie->title }}</option>
                %foreach($technologie->technologies as $technologie)
                  <option value="{{ $technologie->id }}" {{ isset($tags) && in_array($technologie->id, $tags) ? "selected" : "" }}>{{ $technologie->title }}</option>
                %endforeach
              </optgroup>
            %endforeach
          </select>
          <div class="select__arrow"></div>
        </div>
      </div>
    %endif
  </div>
  <div class="row">
    <div class="col-sm-4">
      <div class="form-group">
        <div class="checkbox">
          <label class="control control--radio">
            <input type="checkbox" name="remember" id="preview-editor-content"/> <span style="position: relative; top: -2px; right: -5px">Prévisualisé</span>
            <div class="control__indicator"></div>
          </label>
        </div>
      </div>
    </div>
    <div class="col-sm-4">
      <div class="form-group">
        <div class="checkbox">
          <label class="control control--radio">
            <input type="checkbox" name="remember" id="change-editor-theme"/> <span style="position: relative; top: -2px; right: -5px">Change de thème</span>
            <div class="control__indicator"></div>
          </label>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-12">
      <div class="form-group">
        <div class="text-muted" style="font-size: 12px"><em>* Le formulaire utilise la syntaxe <a href="https://fr.wikipedia.org/wiki/Markdown#Formatage" style="text-decoration: underline;">markdown</a>.</em></div>
        <div id="editor">
          <textarea name="content" style="display: none; min-height: 600px; border-radius: 0px; margin: 0; border: none; resize: none;" placeholder="Votre contenu ici...">{{ $content ?? "" }}</textarea>
        </div>
      </div>
    </div>
  </div>
  <div class="form-group text-right">
    <button class="btn btn-danger">{{ $message }}</button>
  </div>
</form>
%endguest
