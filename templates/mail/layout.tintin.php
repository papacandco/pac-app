<!DOCTYPE html
  PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>{{ $title ?? __('about.description') }} - {{ config('app.name') }}</title>
  <style type="text/css">
    %font-face {
      font-family: 'Montserrat';
      font-style: normal;
      font-weight: 400;
      src: local('Montserrat Regular'), local('Montserrat-Regular'), url(https://fonts.gstatic.com/s/montserrat/v14/JTUSjIg1_i6t8kCHKm459WRhyzbi.woff2) format('woff2');
      unicode-range: U+0460-052F, U+1C80-1C88, U+20B4, U+2DE0-2DFF, U+A640-A69F, U+FE2E-FE2F;
    }
    %media screen {
      %font-face {
        font-family: 'Montserrat';
        font-style: normal;
        font-weight: 400;
        src: local('Montserrat Regular'), local('Montserrat-Regular'), url(https://fonts.gstatic.com/s/montserrat/v14/JTUSjIg1_i6t8kCHKm459WRhyzbi.woff2) format('woff2');
        unicode-range: U+0460-052F, U+1C80-1C88, U+20B4, U+2DE0-2DFF, U+A640-A69F, U+FE2E-FE2F;
      }
    }
  </style>
</head>

<body>
  <table cellspacing="0" cellpadding="0" border="0" width="100%"
    style="font-size: 1em; font-family: 'Montserrat', 'Lucida Grande', 'Lucida Sans Unicode', Tahoma, Sans-Serif;">
    <tr>
      <td class="navbar navbar-inverse" align="center">
        <table width="650px" cellspacing="0" cellpadding="3" class="container" style="padding-bottom: 20px; padding-top: 0; padding-left: 0; padding-right: 0">
          <tr class="navbar navbar-inverse">
            <td colspan="4">
              <div>
                <strong style="color: #111111; font-size: 1.9em">Code <span style="color: #144571">Learning</span>
                  Club</strong>
                <br>
                <span style="color: #111111">{ {{ __('vendor.slogant') }} }</span>
              </div>
            </td>
          </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td bgcolor="#FFFFFF" align="center">
        <table width="650px" cellspacing="0" cellpadding="3" class="container">
          <tr>
            <td>%inject('content')</td>
          </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td bgcolor="#FFFFFF" align="center">
        <table width="650px" cellspacing="0" cellpadding="3" class="container">
          <tr>
            <td align="left">
              <p>L'Equipe de <a href="{{ app_env('APP_URL') }}">Papac & Co</a>.</p>
            </td>
          </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td bgcolor="#FFFFFF" align="center">
        <table width="650px" cellspacing="0" cellpadding="3" class="container">
          <tr>
            <td align="left">
              <a href="https://www.facebook.com/codelearningclub" id="facebook" title="Partagez sur facebook"><img class="no-img-bg-color" src="{{ app_env('APP_URL') }}/img/socials/facebook.svg" alt="facebook" style="width: 18px;"></a>
              <a href="https://twitter.com/franck_dakia" alt="Partager sur Twitter"><img class="no-img-bg-color" src="{{ app_env('APP_URL') }}/img/socials/twitter.svg" alt="Twitter" style="width: 18px; margin-left: 5px"></a>
              <a href="https://www.linkedin.com/company/papac-and-co" alt="Partager sur Linkedin"><img class="no-img-bg-color" src="{{ app_env('APP_URL') }}/img/socials/linkedin.svg" alt="Twitter" style="width: 18px; margin-left: 5px"></a>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>

</html>
