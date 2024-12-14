%php
$annonces = get_annonces();
%endphp

%if (count($annonces) > 0)
<div id="ads-carousel" class="owl-carousel" style="height: auto !important">
  %foreach($annonces as $ads)
  <div class="container-fluid bg-blue" style="background: {{ $ads->bg_color }} !important; min-height: 50px !important; max-height: 50px !important">
    <div class="container text-center hidden-xs">
      <span class="pull-right text-white label label-primary" style="background: #151515">Ads</span>
      <div style="padding: 5px; color: {{ $ads->font_color }} !important">
        <img class="img-responsive" src="{{ $ads->cover }}" style="max-width: 40px; min-width: 40px; max-height: 40px; min-height: 40px; display: inline-block; background-color: #eee">
        <a traget="_blank" href="{{ $ads->link }}" style="margin-left: 5px; color: {{ $ads->link_color }} !important;  text-decoration: underline;" target="_blank">
          {{{ $ads->message }}} >
        </a>
      </div>
    </div>
    <div class="visible-xs">
      <hr class="visible-xs" style="margin-top: 0px; margin-bottom: 5px">
      <div class="row">
        %include('partials.ads-sm')
      </div>
      <hr class="hidden-xs" style="margin-top: 5px">
      <div class="visible-xs" style="margin-bottom: 10px"></div>
    </div>
  </div>
  %endforeach
</div>
%endif
