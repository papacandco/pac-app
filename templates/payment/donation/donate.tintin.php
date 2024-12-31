%extends('layouts.app', ['active' => '#', 'isolate' => true, 'body_class' => 'bg-image', 'do_not_show_buycoffe_page' => true])

%block('title', 'Faire un don')

%block('seo')
  %include('partials.seo', ['title' => "Faites un don", 'description' => "Nous sommes une petite équipe de volontaires qui s'est donnée comme mission d'aider des développeurs francophone à améliorer leur compétence en les encadrant et leurs donnant les ressources nécessaires afin d'atteindre leurs objectifs. <br>Nous apprécierons toutes contributions/dons susceptible de nous aider à rendre cela possible.", 'author' => "Franck DAKIA"])
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
      <h1 class="text-center hidden">Faites votre don</h1>
    </div>
    <div class="col-sm-offset-2 col-sm-4 col-xs-12">
      %include('partials.loader')
      <a href="/" style="margin-left: 9px; margin-bottom: 40px;"><i class="fa fa-arrow-left text-blue"></i></a>
      <p style="padding: 10px;">
        <strong>A propos</strong><br/>
        Nous sommes une petite équipe de volontaires qui s'est donnée comme mission d'aider les développeurs à améliorer leurs compétences en les encadrant et leurs donnant les ressources nécessaires afin d'atteindre leurs objectifs. <br>Nous apprécierons toutes contributions/dons susceptible de nous aider à rendre cela possible.
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
    <div class="col-sm-4 col-xs-12 shadow-sm auth-form" style="padding: 5px 10px 15px 10px">
      <form action="{{ route('donate') }}" method="POST" style="margin-top: 25px">
        %csrf
        %guest
          <label>Qui vous êtes ?</label>
          <div class="form-group">
            <input type="text" id="name" name="name" value="{{ old('name', '') }}" class="form-control" placeholder="Votre nom complet" required/>
          </div>
          <div class="form-group">
            <input type="email" id="email" name="email" value="{{ old('email', '') }}" class="form-control" placeholder="Votre Email" required/>
          </div>
        %endguest
        %auth
        <p style="margin-bottom: 18px">
          <img src="{{ auth()->user()->avatar }}" class="img-circle img-responsive" alt="Favoris" style="width: 35px; height: 35px; display: inline-block;">
        </p>
        %endauth
        %if(!auth()->check() || is_null(auth()->user()->country))
          <div class="form-group select">
            <select name="country" class="form-control" required>
              <option value="">Votre pays</option>
              %loop(get_country_list() as $country)
                <option value="{{ $country->code }}" {{ old('country', 'CI') == $country->code ? 'selected' : '' }}>{{ $country->name }}</option>
              %endloop
            </select>
            <div class="select__arrow"></div>
          </div>
        %endif
        <hr>
        {## <div class="checkbox" style="display: inline-block; margin-right: 5px;">
          <label class="control control--radio">
            <input type="radio" name="channel" value="card" id="method-paypal" checked/> <span class="amount-position" style="position: relative; top: -2px">Paypal</span>
            <div class="control__indicator"></div>
          </label>
        </div>
        <div class="checkbox" style="display: inline-block; margin-left: 10px;">
          <label class="control control--radio">
            <input type="radio" name="channel" value="mm" id="method-mobile-money"/> <span class="amount-position" style="position: relative; top: -2px">Mobile Money</span>
            <div class="control__indicator"></div>
          </label>
        </div> ##}
        <div id="mobile-money-section">
          <label style="margin-top: 10px">Choisisez une dévise ?</label>
          <div class="form-group select">
            <select name="currency" class="form-control" required>
              %loop(["XOF" => "FCFA (Ouest Afrique)", "XAF" => "FCFA (Centre Afrique)", "CDF" => "Franc CDF", "GNF" => "Franc guinéen", "USD" => "Dollar US"] as $code => $name)
                <option value="{{ $code }}" {{ old('currency', 'XOF') == $code ? 'selected' : '' }}>{{ $name }} ({{ $code }})</option>
              %endloop
            </select>
            <div class="select__arrow"></div>
          </div>
          <div class="form-group" style="margin-top: 10px;">
            <input type="number" id="amount" name="amount" value="{{ old('amount', '') }}" class="form-control" placeholder="Montant" required/>
          </div>
        </div>
        <div class="form-group">
          <button class="btn btn-primary btn-block btn-login login-form-button" style="display: inline-block">
            <i class="fa fa-money"></i> Donner
          </button>
          {## <a class="btn btn-primary btn-block btn-login login-form-button" href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=8QGZWFCFJ2ZG2&source=url" style="display: inline-block">
            <i class="fa fa-money"></i> Donner via paypal
          </a> ##}
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
