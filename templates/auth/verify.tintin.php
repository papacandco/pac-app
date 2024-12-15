%extends('layouts.app', ['active' => '#', 'isolate' => true, 'bg_class' => 'bg-image', 'without_footer' => true])

%block('title', 'Vérifiez votre adresse e-mail')

%block('style')
  <style type="text/css">
    body.bg-image {
      background-size: cover !important;
    }
  </style>
%endblock

%block('content')
<div class="container" style="padding: 50px;">
  <div class="row">
    <div class="col-sm-offset-3 col-sm-6 col-xs-12 bg-white" style="padding: 40px;">
      <h3>{{ __('Vérifiez votre adresse e-mail') }}</h3>
      %if(session('resent'))
      <div class="alert alert-success" role="alert">
        {{ __('Un nouveau lien de vérification a été envoyé à votre adresse e-mail.') }}
      </div>
      %endif
      <p>
        {{ __('Avant de continuer, veuillez vérifier votre courrier électronique pour un lien de vérification.') }}
        {{ __('Si vous n\'avez pas reçu l\'email') }}, <a href="{{ route('verification.resend') }}">{{ __('cliquez ici pour demander un autre') }}</a>.
      </p>
    </div>
  </div>
</div>
%endblock
