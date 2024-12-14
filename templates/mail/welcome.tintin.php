%extends('mail.layout')

%block('content')
<br>
Bienvenue à toi <b>Coder Warrior ({{ $name }})</b>, enfile ton casque et ton bouclier, nous allons manger du <b>code</b> 🤓.
<br>
<p>
Tout ça pour dire que nous somme content de voir un nouveau passionné, s'inscrir sur le site des développeurs passionnés <a href="{{ app_env('APP_URL') }}">Papac & Co</a> 😍.
</p>
<br>
<p>Chez Papac & Co, l'expérience client est au cœur de tout ce que nous faisons. C'est pourquoi nous venons travailler chaque jour. Toutes les réponses à cette boîte de réception sont surveillées par moi-même Franck DAKIA (Papac Dev), donc si vous souhaitez entrer en contact directement et fournir des commentaires qui pourraient nous aider à vous aider, veuillez contact <a href="mailto:hello%papacandcohq.com">hello%papacandcohq.com</a> et je m'assurerai que nous y répondions immédiatement. Aucun problème n'est trop petit. Si cela compte pour vous, cela compte pour nous, alors n'hésitez pas à nous contacter si vous avez besoin d'un service.</p>
<br>
<p>
  Nous vous encourageons à regarder plusieurs fois les tutoriels et à les pratiquer en même tant que la présentation 😉.
</p>
%include('mail.reject-message')
%endsection
