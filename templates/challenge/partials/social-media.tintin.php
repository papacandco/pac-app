%block('twitter')
  <meta name="twitter:card" content="summary">
  <meta name="twitter:site" content="%franck_dakia">
  <meta name="twitter:creator" content="%franck_dakia">
  <meta name="twitter:title" content="{{ $challenge->title }}">
  <meta name="twitter:description" content="{{ $challenge->description }}">
  <meta name="twitter:image" content="{{ app_env('APP_ENV') }}/img/brand/codelearningclub.png">
%endsection

<!-- Facebook -->
%block('facebook')
  <meta property="og:url" content="{{ app_env('APP_ENV') }}">
  <meta property="og:title" content="{{ $challenge->title }}">
  <meta property="og:description" content="{{ $challenge->description }}">
  <meta property="og:type" content="website">
  <meta property="og:image" content="{{ app_env('APP_ENV') }}/img/brand/codelearningclub.png">
  <meta property="og:image:secure_url" content="{{ app_env('APP_ENV') }}/img/brand/codelearningclub.png">
  <meta property="og:image:type" content="image/png">
  <meta property="og:image:width" content="150">
  <meta property="og:image:height" content="150">
%endsection
