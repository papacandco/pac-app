%guest
  %isset($landing_actived)
    <p class="mission-header">
      <img src="/img/misc/bird.svg" width="70px" alt="{{ __('about.new_letter.title') }}">
    </p>
  %else
    <p class="mission-header">
      <strong class="font-weight-bolder">
        {{ __('about.new_letter.title') }}
      </strong>
    </p>
  %endisset
  <p>
    {{ __('about.new_letter.description') }}
  </p>
  <form action="{{ route('support.newsletter') }}" method="post">
    %raw session()->put($field_name ?? 'newsletter_email_field', $secure_prefix ?? ''); %endraw
    %csrf
    <div class="input-group">
      <input type="email" placeholder="Adresse E-mail" name="{{ $secure_prefix ?? '' }}" class="form-control" required>
      <input type="hidden" name="field_name" value="{{ $field_name ?? 'newsletter_email_field' }}">
      <span class="input-group-btn">
        <button type="submit" class="btn btn-primary">{{ __('about.new_letter.btn') }}</button>
      </span>
    </div>
  </form>
%endguest
