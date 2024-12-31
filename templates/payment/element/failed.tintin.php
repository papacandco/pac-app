%extends('errors.layout', ['code' => 'Paiement échoué'])

%block('error')
  <h1 class="text-success">Paiement échoué</h1>
  <p>Désolé votre paiement ne sait pas bien passer. <a href="{{ route('payment.element', ['type' => get_class($transaction->target) == "App\Models\Tutorial" ? "tutorial" : "curriculum", 'id' => $transaction->target->id, 'slug' => $transaction->target->slug]) }}" style="text-decoration: underline">Cliquer ici si vous voulez recommancer.</a></p>
  <br/>
  <p>Merci pour votre soutient <b>{{ $transaction->user->name }}</b>. <a href="{{ app_env('APP_URL') }}" style="text-decoration: underline">Papac & Co</a></p>
%endblock
