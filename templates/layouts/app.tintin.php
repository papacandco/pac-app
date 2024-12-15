<!DOCTYPE html>
%auth
  <html class="dark-theme" lang="{{ str_replace('_', '-', client_locale()) }}">
%else
  <html class="dark-theme" lang="{{ str_replace('_', '-', client_locale()) }}">
%endauth
<head>
  <meta charset="utf-8">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="shortcut icon" type="image/png" href="{{ app_env('APP_URL') }}/img/brand/favicon.png"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="search" type="application/opensearchdescription+xml" href="/opensearch.xml" title="{{ app_env('APP_NAME') }}">
  <link rel="alternate" type="application/rss+xml" title="{{ config('app.name') }} | Flux" href="//feeds.feedburner.com/codelearningclub">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css">
  <link rel="stylesheet" type="text/css" href="/css/app.css" id="main-css-file">
  <link rel="stylesheet" type="text/css" href="/css/plyr/plyr.css" />
  %guest
    <script>
      window.isDarkMode = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches
      if (!window.isDarkMode || sessionStorage.getItem("code_learning_club_switch_to_theme") == "light") {
        document.querySelector("html").classList.remove("dark-theme")
      } else {
        document.querySelector("html").classList.add("dark-theme")
      }
    </script>
  %else
    <script>
      if (sessionStorage.getItem("code_learning_club_switch_to_theme") == "light") {
        document.querySelector("html").classList.remove("dark-theme")
      } else {
        document.querySelector("html").classList.add("dark-theme")
      }
    </script>
  %endguest

  %block('seo')
    %include('meta::manager', [
      'title'         => __('about.title'),
      'description'   => __('about.description'),
      'image'         => app_env('APP_URL') . "/img/brand/logo.png",
    ])
  %endblock

 <title>%block('title') | {{ config('app.name') }}</title>

  %if(app_env('SEARCH_JSON'))
  <script type="application/ld+json">{
    "%context": "http://schema.org",
    "%type": "WebSite",
    "url" : "{{ app_env('APP_URL') }}",
    "potentialAction": {
      "%type": "SearchAction",
      "target": "{{ route('search.index') }}?q={search_term_string}",
      "query-input": "required name=search_term_string"
    }
  }</script>
  %endif
  %inject('style')
  <style>
    .select2-results__options {
      color: #000 !important;
    }
  </style>
  %auth()
    <meta id="notification-channel" content="{{ 'notification-' . md5(auth()->user()->id) }}">
    <meta id="pusher-app-key" content="{{ app_env("PUSHER_APP_KEY") }}">
    <script src="/js/notification.js"></script>
  %endauth
</head>

<body style="overflow-x: hidden !important">
  <noscript>
    <style>
      .simplebar-content-wrapper {
        overflow: auto;
      }
    </style>
    <div id="noscript-warning">Papac & Co nécessite du JavaScript pour se lancer correctement.</div>
  </noscript>
  %production
    %include("partials.tagmanager")
  %endproduction

  %includeWhen(!isset($isolate), 'layouts.navbar', compact('active'))
  <main style="margin-bottom: 30px;">
    %inject('content')
  </main>

  %if(!isset($isolate))
    %includeWhen(!isset($without_footer), 'layouts.footer')
  %else
    <div style="position: fixed; bottom: 20px; left: 10px;">%include('layouts.partials.theme-button')</div>
  %endif

  %if(config('app.env') == 'local')
    <script src="http://localhost:35729/challengereload.js"></script>
  %endif

  <script type="text/javascript" src="/js/plyr/plyr.js"></script>
  <script type="text/javascript" src="/js/app.js"></script>
  %inject('script')
  %include('layouts.flash')
  {## %if(!isset($do_not_show_buycoffe_page))
    <script data-name="BMC-Widget" src="https://cdnjs.buymeacoffee.com/1.0.0/widget.prod.min.js" data-id="iOLqZ3h" data-description="Soutenez-nous sur Buy me a coffee!" data-color="#144571" data-position="right" data-x_margin="18" data-y_margin="18"></script>
  %endif ##}
</body>
</html>
