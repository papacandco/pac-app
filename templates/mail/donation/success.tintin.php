%extends('mail.layout', ['title' => 'Paiement réussit'])

%block('content')
  <br>
  {{ get_greeting_by_time() }} <b>{{ $transaction->user->name }}</b>,
  <br>
  <br>
  <p>Sachez que nous sommes reconnaissant parce que ceci va nous permettre de supporter les charges des serveurs et de la production du contenu.</p>
  <br/>
  <p>😍 Merci pour votre soutient <b>{{ $transaction->user->name }}</b>. <a href="{{ app_env('APP_URL') }}" style="text-decoration: underline">Papac & Co</a></p>
%endblock
