@extends('errors.layout', ['code' => 'Paiement réussit'])

@section('error')
  <h1 class="text-success">Paiement réussit</h1>
  <p>
    Félicitation. Votre paiement à bien été effectué.
    @if (get_class($transaction->target) == "App\Models\Tutorial")
      <a href="{{ route('tutorial.reader', ['slug' => $transaction->target->slug, 'id' => $transaction->target->id]) }}">Voir mon achat</a>
    @else
      <a href="{{ route('curriculum.single', ['slug' => $transaction->target->slug]) }}">Voir mon achat</a>
    @endif
  </p>
  <br/>
  <p><a href="/" style="text-decoration: underline">Papac & Co</a></p>
@endsection
