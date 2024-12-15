%extends('mail.layout')

%block('content')
Il y a eu une nouvelle connexion sur le dashboard.
<br>
Addresse IP: <b>{{ $ip }}</b>
%endblock
