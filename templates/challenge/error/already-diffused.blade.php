@extends('errors.layout', ['code' => 401])

@section('error')
  <h1>{!! $challenge->diffusionIcon() !!} Live</h1>
  <p>
    Désolé, le challenge a été déjà diffusé. Vous pouvez revoir ce challenge <a href="{{ route('challenge.single', ['challenge' => $challenge->id, 'slug' => $challenge->slug]) }}" style="text-decoration: underline;">ici</a>
  </p>
@endsection
