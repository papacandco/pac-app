%php
$annonces = get_annonces();
%endphp

%if (count($annonces) > 0)
  <hr class="visible-xs" style="margin-top: 0px; margin-bottom: 5px">
  <div id="ads-carousel" class="owl-carousel">
  %foreach($annonces as $ads)
    <div class="row" style="margin-left: 0px; background-color: {{ $ads->bg_color }} !important">
    	%include('partials.ads-sm')
		</div>
  %endforeach
	</div>
  <hr class="hidden-xs" style="margin-top: 5px">
  <div class="visible-xs" style="margin-bottom: 10px"></div>
%endif
