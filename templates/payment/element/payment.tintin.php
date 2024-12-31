%extends('layouts.app', ['active' => '#', 'isolate' => true, 'body_class' => 'bg-image', 'do_not_show_buycoffe_page' => true])

%block('title', 'Paiement')

%block('seo')
  %include('partials.seo', ['title' => "Paiement: " . $element->description, 'description' => "Paiemnt de la formation: " . $element->description, 'author' => "Franck DAKIA"])
%endblock

%block('style')
  <style type="text/css">
    .amount-position {
      position: relative; top: 1px; right: -5px;
    }
    body.bg-image {
      background-size: cover !important;
    }
  </style>
%endblock

%block('content')
<div class="container" style="padding: 40px;">
  <div class="row">
    <div class="col-sm-12">
      <h1 class="text-center hidden">Paiement</h1>
    </div>
    <div class="col-sm-offset-2 col-sm-4 col-xs-12">
      %include('partials.loader')
      <a href="/" style="margin-left: 9px; margin-bottom: 40px;"><i class="fa fa-arrow-left text-blue"></i></a>
      <p style="padding: 10px;">
        <strong>{{ $element->title }}</strong><br>
        {{ $element->description }}
      </p>
      <div style="margin-top: 10px; text-align: center;">
        <p class="text-left" style="font-size: 11px">
          Le paiement par carte bancaire n'est pas encore disponible pour les devises suivantes :
          <ul class="text-left" style="font-size: 11px">
            <li>GNF (Guinée)</li>
            <li>CDF (RDCongo CDF)</li>
          </ul>
        </p>
        <img src="https://docs.cinetpay.com/images/latest_box.webp" alt="Logo CinetPay" style="display: inline-block; width: 210px"><br />
        <span style="font-size: 10px" class="text-muted"><i class="fa fa-lock"></i> Paiement sécurisé</span>
      </div>
    </div>
    <div class="col-sm-4 col-xs-12 shadow-sm auth-form" style="padding: 10px">
      <form action="{{ route('payment.initialize') }}" method="POST">
        %csrf
        <input type="hidden" name="element_id" value="{{ $element->id }}">
        <input type="hidden" name="element_type" value="{{ get_class($element) }}">
        <!--<img class="img-responsive" src="{{ $element->cover }}" alt="{{ $element->title }}" style="max-width: auto;">-->
        <br />
        <b>{{ $element->price }} XOF</b>
        <div id="mobile-money-section">
          <label style="margin-top: 10px">Choisisez une dévise ?</label>
          <div class="form-group select">
            <select name="currency" class="form-control" required>
              %loop(["XOF" => "FCFA (Ouest Afrique)", /*"XAF" => "FCFA (Centre Afrique)", "CDF" => "Franc CDF", "GNF" => "Franc guinéen", "USD" => "Dollar US"*/] as $code => $name)
                <option value="{{ $code }}" {{ old('currency') == $code ? 'selected' : '' }}>{{ $name }} ({{ $code }})</option>
              %endloop
            </select>
            <div class="select__arrow"></div>
          </div>
        </div>
        <div class="form-group">
          <button class="btn btn-primary btn-block btn-login login-form-button" style="display: inline-block">
            <i class="fa fa-money"></i> Validé le paiement
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
%endblock

%block('script')
<script type="text/javascript">
  $('#method-paypal').click(function () {
    $("#mobile-money-section").addClass("hidden");
    $("button.login-form-button").addClass("hidden");
    $("a.login-form-button").removeClass("hidden");
  });
  $('#method-mobile-money').click(function () {
    $("#mobile-money-section").removeClass("hidden");
    $("button.login-form-button").removeClass("hidden");
    $("a.login-form-button").addClass("hidden");
  });
  $('.btn-login').click(function (e) {
    if (!$(e.target).hasClass('login-form-button')) {
      return $('.lds-ellipsis').fadeIn(100);
    }
    if ($('[name="email"]').val().length !== 0 && $('[name="password"]').val().length !== 0) {
      $('.lds-ellipsis').fadeIn(100);
    }
  });
</script>
%endblock
