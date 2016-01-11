<html>
    <head>
        <title>App Name - @yield('title')</title>
        <link rel="stylesheet" href="/css/app.css">
    </head>
    <body class="@yield('body-class')">
        
        <nav class="navbar navbar-main navbar-inverse navbar-fixed-top">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="/">SlackReport</a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                    @section('topbar-right')
                        @if (Auth::guest())
                            <li><a href="/account/login">Login</a></li>
                            <li><a href="/account/register">Create an account</a></li>
                        @else
                            <li><a href="/me/dashboard">My dashboard</a></li>
                            <li><a href="/me/account">{{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}</a></li>
                            <li><a href="/account/logout">Logout</a></li>
                        @endif
                    @show
                    </ul>
                </div>
            </div>
        </nav>
            
        <div class="container-header-wrapper">
            <div class="container">

                @if(Session::get('message'))
                    <div class="alert alert-dismissible alert-info">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        {{ Session::get('message') }}
                    </div>
                @endif

                @yield('content_header')

            </div>
        </div>
        
        @yield('top_content')
        <div class="container main-container"> 
            @yield('content')
        </div>

        <div class="container">
            <footer>
        <div class="row">
          <div class="col-lg-12">

            <ul class="list-unstyled">
              <li><a href="http://news.bootswatch.com" onclick="pageTracker._link(this.href); return false;">Blog</a></li>
              <li><a href="http://feeds.feedburner.com/bootswatch">RSS</a></li>
              <li><a href="https://twitter.com/bootswatch">Twitter</a></li>
              <li><a href="https://github.com/thomaspark/bootswatch/">GitHub</a></li>
              <li><a href="../help/#api">API</a></li>
              <li><a href="../help/#support">Support</a></li>
            </ul>
            <p>No metric or statical data is stored or communicated. All your data is yours and remains in your Analytics account.</p>
            <p>Made by <a href="http://www.tristanfarneau.com">Tristan Farneau</a>. Contact him at <a href="mailto:hello@tristanfarneau.com">hello@tristanfarneau.com</a>.</p>
          </div>
        </div>

      </footer>
        </div>

        <script src="/js/jquery.min.js"></script>
        <script src="/js/bootstrap.min.js"></script>
        @yield('scripts')

    </body>
</html>