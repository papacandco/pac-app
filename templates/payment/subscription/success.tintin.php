%extends('errors.layout', ['code' => 'Paiement réussit'])

%block('error')
  <h1 class="text-success">Paiement réussit</h1>
  <p>Votre souscription <b>{{ $transaction->target->title }}</b> est activé.</p>
  <p>{{{ nl2br($transaction->target->description) }}}</p>
  <br/>
  <p><a href="/" style="text-decoration: underline">Papac & Co</a></p>
%endsection
