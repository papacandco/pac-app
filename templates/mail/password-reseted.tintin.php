%extends('mail.layout')

%block('content')
  <p>
    😍 Votre mot de passe a été modifié avec succès.
    <br>
    Nous vous encourageons à regarder plusieurs fois les tutoriels et à les pratiquer en même que la présentation 😉.
  </p>
  %include('mail.reject-message')
%endblock
