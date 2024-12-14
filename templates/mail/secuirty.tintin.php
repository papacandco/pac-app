%extends('mail.layout')

%block('content')
Cher Coder,
<br/><br/>
Nous venons de noter que votre compte Scaleway était accessible à partir d'une adresse IP que nous n'avions pas vue depuis un moment:
<br/><br/>
<p>
------------------------------------------<br/>
Compte: dakiafranck%gmail.com<br/>
Adresse IP: 154.68.42.90<br/>
Navigateur: Mozilla / 5.0 (X11; Ubuntu; Linux x86_64; rv: 70.0) Gecko / 20100101 Firefox / 70.0<br/>
------------------------------------------<br/>
</p>
<p>
Si c'était vous, vous pouvez ignorer cette alerte. Si vous suspectez une activité inhabituelle sur votre compte, veuillez contacter le support.
<p>
%include('mail.reject-message')
%endsection
