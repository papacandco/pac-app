%extends('mail.layout')

%block('content')
<br>
{{ get_greeting_by_time() }} <b>{{ $name }}</b>,
<br>
<br>
<p>
Clique rapidement sur le lien ci-dessous pour vérifier votre adresse email. <br><br><br>🧐 <a href="{{ $url }}" style="text-decoration: underline;">Vérifions ton adresse e-mail</a> 👈.
</p>
%include('mail.reject-message')
%endsection
