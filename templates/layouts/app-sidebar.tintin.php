<style type="text/css">
  block.container {
    padding-top: 20px;
    padding-right: 30px;
    padding-left: 30px;
    padding-bottom: 20px;
  }

  body,html{
    height: 100%;
  }

  nav.sidebar, .main {
    -webkit-transition: margin 200ms ease-out;
    -moz-transition: margin 200ms ease-out;
    -o-transition: margin 200ms ease-out;
    transition: margin 200ms ease-out;
  }

  /* .....NavBar: Icon only with coloring/layout.....*/

  /*small/medium side display*/
  %media (min-width: 768px) {

    /*Allow main to be next to Nav*/
    .main{
      position: absolute;
      width: calc(100% - 40px); /*keeps 100% minus nav size*/
      margin-left: 40px;
      float: right;
    }

    /*lets nav bar to be showed on mouseover*/
    nav.sidebar:hover + .main{
      margin-left: 200px;
    }

    /*Center Brand*/
    nav.sidebar.navbar.sidebar>.container .navbar-brand, .navbar>.container-fluid .navbar-brand {
      margin-left: 0px;
    }
    /*Center Brand*/
    nav.sidebar .navbar-brand, nav.sidebar .navbar-header{
      text-align: center;
      width: 100%;
      margin-left: 0px;
    }

    /*Center Icons*/
    nav.sidebar a{
      padding-right: 13px;
    }

    /* Colors/style dropdown box*/
    nav.sidebar .navbar-nav .open .dropdown-menu {
      position: static;
      float: none;
      width: auto;
      margin-top: 0;
      background-color: transparent;
      border: 0;
      -webkit-box-shadow: none;
      box-shadow: none;
    }

    /*allows nav box to use 100% width*/
    nav.sidebar .navbar-collapse, nav.sidebar .container-fluid{
      padding: 0 0px 0 0px;
    }

    /*colors dropdown box text */
    .navbar-inverse .navbar-nav .open .dropdown-menu>li>a {
      color: #777;
    }

    /*gives sidebar width/height*/
    nav.sidebar{
      width: 200px;
      height: 100%;
      margin-left: -160px;
      float: left;
      z-index: 8000;
      margin-bottom: 0px;
    }

    /*give sidebar 100% width;*/
    nav.sidebar li {
      width: 100%;
    }

    /* Move nav to full on mouse over*/
    nav.sidebar:hover{
      margin-left: 0px;
    }
    /*for hiden things when navbar hidden*/
    .forAnimate{
      opacity: 0;
    }
  }

  /* .....NavBar: Fully showing nav bar..... */

  %media (min-width: 1330px) {

    /*Allow main to be next to Nav*/
    .main{
      width: calc(100% - 200px); /*keeps 100% minus nav size*/
      margin-left: 200px;
    }

    /*Show all nav*/
    nav.sidebar{
      margin-left: 0px;
      float: left;
    }
    /*Show hidden items on nav*/
    nav.sidebar .forAnimate{
      opacity: 1;
    }
  }

  nav:hover .forAnimate{
    opacity: 1;
  }

  block{
    padding-left: 15px;
  }

  .verticle-content {
    display: block;
  }
</style>

<nav class="navbar navbar-default sidebar" role="navigation">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-sidebar-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-sidebar-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="{{ $active == 'tutorial' ? 'active' : '' }}">
          <a href="{{ route('tutorial') }}">{{ __('navbar.tutorial') }}</a>
        </li>
        <li class="{{ $active == 'curriculum' ? 'active' : '' }}">
          <a href="{{ route('curriculum') }}">{{ __('navbar.course') }}</a>
        </li>
        <li class="{{ $active == 'forum' ? 'active' : '' }}">
          <a href="{{ route('forum') }}">{{ __('navbar.forum') }}</a>
        </li>
        <li class="{{ $active == 'podcast' ? 'active' : '' }}">
          <a href="{{ route('podcast') }}">{{ __('navbar.podcast') }}</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
