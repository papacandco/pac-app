%extends('mail.layout', ['title' => 'Paiement réussit'])

%block('content')
  <p>{{ get_greeting_by_time() }} <b>{{ $transaction->user->name }}</b>,</p>

  <p>
    Félicitations ! Vous êtes désormais abonné(e) à <b>{{ $transaction->target->title }}</b>.
  </p>

  <p>
    <br/>Voici un bref récapitulatif :
    <ul>
      <li>Produit : {{ $transaction->target->title }} ({{ $transaction->target->identifier }})</li>
      <li>Date de souscription : {{ $transaction->created_at->format('d/m/Y') }}</li>
    </ul>
  </p>

  <p>
    Votre souscription est active. Si vous avez des questions ou besoin d'aide, contactez-nous à [adresse e-mail du service client] ou [numéro de téléphone du service client].
  </p>

  <p>
    Restez à l'affût de nos emails pour des mises à jour et offres exclusives.<br /><br />
    Bienvenue chez <a href="{{ app_env('APP_URL') }}">code learning club</a> !
  </p>

  <br />

  <p>Cordialement</p>
%endsection
