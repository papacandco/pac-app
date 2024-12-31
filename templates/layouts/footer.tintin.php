<footer>
  <div class="footer-presentation">
    <div class="container" style="padding: 20px; max-width: 1200px;">
      <div class="row">
        <div class="col-sm-9 hidden-xs">
          <h4 class="text-primary">{{ __('footer.who') }}</h4>
          <div class="row" style="margin-bottom: 20px;">
            <div class="col-sm-12">
              <div style="margin-top: 2px; margin-bottom: 20px; margin-right: 7px">
                <div class="media" style="padding: 5px; border: unset; background: inherit !important;">
                  <div class="media-left">
                    <div class="media-object" style="padding: 5px;">
                      <img src="{{ __('about.author.persons.0.avatar') }}" class="img-circle" alt="Photo Franck DAKIA" style="width: 50px; height: 50px; background-color: #eee">
                    </div>
                  </div>
                  <div class="media-body">
                    <p>
                      {{{ __('about.author.persons.0.description') }}}
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-3 col-xs-12">
          <h4 class="text-primary">{{ __('footer.contact') }}</h4>
          <ul>
            <li>
              <a style="color: inherit;" href="mailto:contact@papac.dev">
                {{ __('footer.contact_by_email') }}
              </a>
            </li>
            <li>
              <a style="color: inherit;" href="https://discord.gg/yhnQhJ4">
                {{ __('footer.contact_by_tchat') }}
              </a>
            </li>
            <li>
              <a style="color: inherit;" href="https://www.youtube.com/channel/UCmQpFXGp7ovk31lti_4K_Jg">
                {{ __('footer.contact_by_youtube') }}
              </a>
            </li>
            <li>{{ __('footer.contact_by_phone1') }}</li>
            <li>{{ __('footer.contact_by_phone2') }}</li>
          </ul>
          <ul class="nav nav-pills">
            <li>
              <a href="https://www.facebook.com/codelearningclub" id="facebook" title="Partagez sur facebook">
                <img class="no-img-bg-color" src="/img/socials/facebook.svg" alt="facebook" style="width: 18px; position: relative; top: -1px;">
              </a>
            </li>
            <li>
              <a href="https://twitter.com/papac-and-co" alt="Partager sur Twitter">
                <img class="no-img-bg-color" src="/img/socials/twitter.svg" alt="Twitter" style="width: 18px; position: relative; top: -1px;">
              </a>
            </li>
            <li>
              <a href="https://www.linkedin.com/company/papac-and-co" alt="Partager sur Linkedin">
                <img class="no-img-bg-color" src="/img/socials/linkedin.svg" alt="Twitter" style="width: 18px; position: relative; top: -1px;">
              </a>
            </li>
            <li>
              <a href="https://github.com/papac-and-co" alt="Partager sur Linkedin">
                <img class="no-img-bg-color" src="/img/socials/github.svg" alt="Twitter" style="width: 18px; position: relative; top: -1px;">
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <div class="footer-copy-right">
    %include('partials.copy-right', ['route' => route('terms'), 'class' => 'text-white'])
  </div>
  <div class="text-center" style="padding: 30px">
    <span class="text-danger">❤️</span> <a href="{{ route("donate") }}" traget="_blank">Faire un don. C'est soutenir&nbsp;<strong>Papac & Co</strong> &nbsp; <i class="fa fa-external-link-alt"></i></a>
  </div>
</footer>
