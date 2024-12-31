%extends('errors.layout', ['code' => 'Paiement réussit'])

%block('error')
  <h1 class="text-success">Paiement réussit</h1>
  <p>Sachez que nous sommes reconnaissant parce que ceci va nous permettre de supporter les charges des serveurs et de la production du contenu.</p>
  <br/>
  <p>Merci pour votre soutient <b>{{ $transaction->user->name }}</b>. <a href="/" style="text-decoration: underline">Papac & Co</a></p>
%endblock
