<html>
    <head>
        <title>Kubby - Your website's analytics in Slack - @yield('title')</title>
        <link rel="stylesheet" href="/css/app.css">
        <link rel="icon" type="image/png" href="/images/logo_64.png" />

        <meta name="description" content="{{ config('constants.SEO_DESC') }}">

        <meta property="og:title" content="{{ config('constants.SOCIAL_TITLE') }}"/>
        <meta property="og:image" content="{{ config('constants.SOCIAL_IMAGE') }}"/>
        <meta property="og:url" content="{{ config('constants.SOCIAL_URL') }}"/>
        <meta property="og:description" content="{{ config('constants.SOCIAL_DESC') }}"/>

        <meta name="twitter:card" content="summary">
        <meta name="twitter:url" content="{{ config('constants.SOCIAL_URL') }}">
        <meta name="twitter:title" content="{{ config('constants.SOCIAL_TITLE') }}">
        <meta name="twitter:description" content="{{ config('constants.SOCIAL_DESC') }}">
        <meta name="twitter:image" content="{{ config('constants.SOCIAL_IMAGE') }}">

    </head>
    <body class="@yield('body-class')">
        
        <nav class="navbar navbar-main navbar-default navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="/">
                    <img src="/images/logo_64.png" alt="">{{ config('constants.SITE_NAME') }}</a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a href="https://twitter.com/share" class="twitter-share-button"{count} data-url="http://kubby.in" data-via="getKubby">Tweet</a>
                            <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
                        </li>   
                    @section('topbar-right')
                        @if (Auth::guest())
                            <li><a href="/account/login">Login</a></li>
                            <li><a href="/account/register">Create an account</a></li>
                        @else
                            <li><a href="/me/dashboard">{{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}</a></li>
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

                <div class="row">
                    <div class="col-md-12">
                        @if (!Auth::guest())
                            <h4>Welcome {{ Auth::user()->first_name }} !</h4>
                        @else
                            <h4>Welcome !</h4>
                        @endif
                    </div>
                </div>

            </div>
        </div>
        
        @yield('top_content')
        <div class="container main-container"> 

            @if (Auth::guest())
                <div class="row">
                    <div class="col-md-12">
                        @yield('content')
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col-md-3">
                        <ul class="nav nav-pills nav-stacked nav-left">
                            <li class="{{ \App\Helpers\MenuHelper::activeMenu('me/dashboard') }}"><a href="/me/dashboard">Dashboard</a></li>
                            <li class="{{ \App\Helpers\MenuHelper::activeMenu('me/generators') }}"><a href="/me/generators">My generators</a></li>
                            <li class="{{ \App\Helpers\MenuHelper::activeMenu('me/services/slack') }}"><a href="/me/services/slack">My Slack teams</a></li>
                            <li class="{{ \App\Helpers\MenuHelper::activeMenu('me/services/stats') }}"><a href="/me/services/stats">My Analytics accounts</a></li>
                            <li class="{{ \App\Helpers\MenuHelper::activeMenu('me/account') }}"><a href="/me/account">My account</a></li>
                        </ul>
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="col-md-12">
                                    Need support ? A feature idea ? Want to tell your opinion ? <a href="mailto:{{ config('constants.SITE_EMAIL') }}">Contact the staff !</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        @yield('content')
                    </div>
                </div>
            @endif
        </div>

        <div class="container">
            <footer>
                <div class="row">
                  <div class="col-lg-12">

                    <ul class="list-unstyled">
                      <li><a href="{{ config('constants.TWITTER_URL') }}">Twitter</a></li>
                      <li><a href="mailto:{{ config('constants.SITE_EMAIL') }}">Contact</a></li>
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
        
        <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

            ga('create', 'UA-72403200-1', 'auto');
            ga('send', 'pageview');
        </script>
        
    </body>
</html>