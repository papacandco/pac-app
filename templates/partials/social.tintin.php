<li>
  <a href="https://www.facebook.com/sharer/sharer.php?u={{ $url ?? app_env('APP_URL') }}" id="facebook" title="Partagez sur facebook">
    <img src="/img/socials/facebook.svg" class="no-img-bg-color" alt="facebook" style="width: 18px; position: relative; top: -1px;">
  </a>
</li>
<li>
  <a href="https://twitter.com/home?status={{ $url ?? app_env('APP_URL') }}" alt="Partager sur Twitter">
    <img src="/img/socials/twitter.svg" class="no-img-bg-color" alt="Twitter" style="width: 18px; position: relative; top: -1px;">
  </a>
</li>
<li>
  <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ $url ?? app_env('APP_URL') }}&title={{ $title ?? __('about.title') }}&source={{ app_env('APP_URL') }}" alt="Partager sur Linkedin">
    <img src="/img/socials/linkedin.svg" class="no-img-bg-color" alt="Twitter" style="width: 18px; position: relative; top: -1px;">
  </a>
</li>
