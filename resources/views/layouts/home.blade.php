<html>
    <head>
        <title>Kubby - Your website's analytics in Slack</title>
        <link href='https://fonts.googleapis.com/css?family=Indie+Flower|Lobster|Arvo:400,700|Pacifico|Bangers|Chewy' rel='stylesheet' type='text/css'>
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
    <body class="@yield('body-class') home">
        
        <div class="wrapper-home">
            <div class="container valign-container">
                <div class="valign">
                    <div class="row">
                        <div class="col-md-4 img-col">
                            <img src="/images/logo_512.png" alt="Kubby" class="main-logo">
                        </div>
                        <div class="col-md-8 text-col">
                            <h1>Kubby.in</h1>
                            <h2>The only bot to get your website's analytics directly in Slack.<br/> Easy and free scheduled reports.</h2>
                            <form action="/account/register" method="get">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Your email" name="email">
                                    <span class="input-group-btn">
                                        <button type="submit" class="btn btn-primary" type="button">Meet Kubby !</button>
                                    </span>
                                </div>  
                            </form>
                            <span class="form-separator">or</span>
                            <a href="/account/login" class="btn btn-primary login-btn">Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
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