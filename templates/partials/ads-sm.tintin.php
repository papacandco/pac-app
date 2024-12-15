<div class="col-xs-12" style=" background-color: {{ $ads->bg_color }} !important;">
  <div style="color: {{ $ads->font_color }}; min-height: 135px !important; max-height: 135px; height:135px; padding: 4px;">
    <span class="pull-right text-white label label-primary" style="background: #2c2c2c; position: relative; top: -10px; right: -10px">Ads</span>

    <div style="margin-bottom: 15px">
      <a href="{{ $ads->link }}" style="color: {{ $ads->link_color }} !important; text-decoration: underline;" target="_blank">
        <div class="media" style="background: none !important; border: none !important">
          <div class="media-left">
            <div class="media-object">
              <img src="{{ $ads->cover }}" style="width: 30px; height: 30px">
            </div>
          </div>
          <div class="media-body" style="position: relative; top: -5px; font-size: 14px; color: {{ $ads->link_color }} !important;">
            {{{ $ads->message }}} >
          </div>
        </div>
      </a>
    </div>

    <div style="position: absolute; bottom: 5px; display: block; width: 85%;" class="text-center">
      %if(!(strlen($ads->message) > 80))
      <a href="{{ $ads->link }}" traget="_blank"
        class="btn btn-primary btn-block btn-outline btn-sm"
        style="position: relative; top: -5px">Voir l'annonce &nbsp; <i class="fa fa-external-link-alt"></i></a>
      %endif
    </div>
  </div>
</div>

