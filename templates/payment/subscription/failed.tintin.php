%extends('errors.layout', ['code' => 'Paiement échoué'])

%block('error')
  <h1 class="text-success">Paiement échoué</h1>
  <p>Désolé votre paiement ne sait pas bien passer. <a href="{{ route('pricing') }}" style="text-decoration: underline">Cliquer ici si vous voulez recommancé.</a></p>
  <br/>
  <p>Merci pour votre soutient <b>{{ $donation->user->name }}</b>. <a href="{{ app_env('APP_URL') }}" style="text-decoration: underline">Papac & Co</a></p>
%endblock
