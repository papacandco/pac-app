%isset($tutorial)
  %if ($tutorial->withPdf())
  <li>
    <a href="{{ $tutorial->pdf }}" target="_blank" title="Télécharge le PDF">
      <img class="no-img-bg-color" src="/img/misc/pdf.svg" alt="Télécharge le PDF" style="width: 18px; position: relative; top: -1px;">
    </a>
  </li>
  %endif
  %if ($tutorial->withSource())
  <li>
    <a href="{{ $tutorial->source }}" target="_blank" title="Télécharge de code source">
      <img class="no-img-bg-color" src="/img/misc/download.svg" alt="Télécharge de code source" style="width: 18px; position: relative; top: -1px;">
    </a>
  </li>
  %endif
  %if ($tutorial->withRepository())
  <li>
    <a href="{{ $tutorial->repository }}" target="_blank" title="Voir le dépôt git">
      <i class="fab fa-github text-white"></i>
    </a>
  </li>
  %endif
  <li>
    %auth
      <a href="#" title="Ajoutez dans vos favoris" data-toggle="modal" data-target="#add-bookmark-modal">
        <img class="no-img-bg-color" src="/img/misc/tag.svg" alt="Favoris" style="width: 18px; position: relative; top: -1px;">
      </a>
    %else
      <a href="{{ route('login', ['redirect' => Request::fullUrl()]) }}" title="Ajoutez dans vos favoris">
        <img class="no-img-bg-color" src="/img/misc/tag.svg" alt="Favoris" style="width: 18px; position: relative; top: -1px;">
      </a>
    %endauth
  </li>
%endif
