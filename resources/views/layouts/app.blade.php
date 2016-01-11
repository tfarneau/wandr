<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
        <meta name="author" content="Coderthemes">

        <link rel="shortcut icon" href="/img/favicon_1.ico">

        <title>App Name - @yield('title')</title>

        <link href="/css/bootstrap.min.css" rel="stylesheet">
        <link href="/css/bootstrap-reset.css" rel="stylesheet">
        <link href="/css/animate.css" rel="stylesheet">

        <link href="/assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
        <link href="/assets/ionicon/css/ionicons.min.css" rel="stylesheet" />

        <link href="/css/style.css" rel="stylesheet">
        <link href="/css/helper.css" rel="stylesheet">
        <link href="/css/app.css" rel="stylesheet">

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
        <!--[if lt IE 9]>
          <script src="js/html5shiv.js"></script>
          <script src="js/respond.min.js"></script>
        <![endif]-->

    </head>
    <body class="@yield('body-class')">
        
        <!-- Aside Start-->
        <aside class="left-panel">

            <!-- brand -->
            <div class="logo">
                <a href="index.html" class="logo-expanded">
                    <i class="ion-social-buffer"></i>
                    <span class="nav-label">Velonic</span>
                </a>
            </div>
            <!-- / brand -->
        
            <!-- Navbar Start -->
            <nav class="navigation">
                <ul class="list-unstyled">
                    <li>
                        <a href="index.html"><i class="ion-home"></i> <span class="nav-label">Dashboard</span></a>
                    </li>
                    @section('menu-left')
                        <li class="active has-submenu">
                            <a href="#"><i class="ion-stats-bars"></i><span class="nav-label">Slack Analytics</span></a>
                            <ul class="list-unstyled">
                                <li><a href="/me/dashboard">Dashboard</a></li>
                                <li><a href="/me/generators/create">Create generator</a></li>
                            </ul>
                        </li>
                    @show

                </ul>
            </nav>
                
        </aside>
        <!-- Aside Ends-->


        <!--Main Content Start -->
        <section class="content">
            
            <!-- Header -->
            <header class="top-head container-fluid">
                <button type="button" class="navbar-toggle pull-left">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                
                <!-- Left navbar -->
                <nav class=" navbar-default hidden-xs" role="navigation">
                    <ul class="nav navbar-nav">
                        <li class="dropdown">
                          <a data-toggle="dropdown" class="dropdown-toggle" href="#">English <span class="caret"></span></a>
                            <ul role="menu" class="dropdown-menu">
                                <li><a href="#">German</a></li>
                                <li><a href="#">French</a></li>
                                <li><a href="#">Italian</a></li>
                                <li><a href="#">Spanish</a></li>
                            </ul>
                        </li>
                    </ul>
                </nav>
                
                <!-- Right navbar -->
                <ul class="list-inline navbar-right top-menu top-right-menu">  
                    <!-- user login dropdown start-->
                    <li class="dropdown text-center">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <img alt="" src="/img/avatar-2.jpg" class="img-circle profile-img thumb-sm">
                            <span class="username">{{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}</span> <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu extended pro-menu fadeInUp animated" tabindex="5003" style="overflow: hidden; outline: none;">
                            <li><a href="/me/account"><i class="fa fa-briefcase"></i> My account</a></li>
                            <li><a href="/account/logout"><i class="fa fa-cog"></i> Logout</a></li>
                        </ul>
                    </li>
                    <!-- user login dropdown end -->       
                </ul>
                <!-- End right navbar -->

            </header>
            <!-- Header Ends -->

            <div class="wraper container-fluid">
                <div class="page-title">

                    @if(Session::get('message'))
                        <div class="alert alert-dismissible alert-info">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            {{ Session::get('message') }}
                        </div>
                    @endif

                    @yield('content_header')
                </div>
                 @yield('content')
            </div>

            <!-- Footer Start -->
            <footer class="footer">
                2015 © Velonic.
            </footer>
            <!-- Footer Ends -->
        </section>
    
        <script src="/js/jquery.js"></script>
        <script src="/js/bootstrap.min.js"></script>
        <script src="/js/modernizr.min.js"></script>
        <script src="/js/pace.min.js"></script>
        <script src="/js/wow.min.js"></script>
        <script src="/js/jquery.scrollTo.min.js"></script>
        <script src="/js/jquery.nicescroll.js" type="text/javascript"></script>

        <script src="/js/jquery.app.js"></script>

        @yield('scripts')

    </body>
</html>