@extends('mail.layout', ['title' => 'Paiement échoué'])

@section('content')
  <br>
  {{ get_greeting_by_time() }} <b>{{ $transaction->user->name }}</b>,
  <br>
  <br>
  <p>Désolé votre paiement ne sait pas bien passer 🤔. <a href="{{ route('donate') }}" style="text-decoration: underline">Cliquer ici si vous voulez recommancer.</a> 👈</p>
  <br/>
  <p>Merci pour votre soutient <b>{{ $donation->user->name }}</b>. <a href="{{ app_env('APP_URL') }}" style="text-decoration: underline">Papac & Co</a></p>
@endsection
