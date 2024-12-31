%extends('mail.layout')

%block('content')
  {{ get_greeting_by_time() }} <b>{{ $name }}</b>,
  <br>
  <p>
    Nous vous invitons au challenge du {{ $due_date->format('m/d/Y à H:i') }}.
    <br/><br/>
    Dans ce challenge nous allons apprendre "{{ $description }}"
  </p>
  <br>
  <br>
  <p>Voici vos information de connexion au challenge:</p>
  <ul>
    <li>
      <b>Lien du challenge</b>: {{ $link }}
    </li>
    <li>
      <b>Votre token</b>: {{ $token }} <em>(Votre token est unique et ne doit pas etre paratage.)</em>
    </li>
  </ul>
  %include('mail.reject-message')
%endblock

