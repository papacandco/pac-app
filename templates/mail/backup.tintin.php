%extends('mail.layout')

%block('content')
{{ get_greeting_by_time() }},
<br>
<p>
  Nouveau backup de la base de donnée.
  <b>Size</b>: {{ $size }} Mo<br/> à <b>{{ date('d/m/Y H:i:s') }}</b><br/>
</p>
%include('mail.reject-message')
%endblock
