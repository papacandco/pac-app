%extends('mail.layout')

%block('content')
{{ get_greeting_by_time() }} <b>{{ $name }}</b>,
<p>
  Vous recevez cet email car nous avons reçu une demande de réinitialisation du mot de passe pour votre compte.
  <br>
  <br>
  🤔 <a href="{{ $url }}" style="text-decoration: underline;">Réinitialiser le mot de passe</a> 👈.
</p>
<p>
  {{ __('Ce lien de réinitialisation de mot de passe expirera dans :count minutes', ['count' => $count]) }}.
</p>
%include('mail.reject-message')
%endblock
