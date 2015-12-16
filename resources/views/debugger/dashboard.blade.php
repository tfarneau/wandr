<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="">

		<title>Wandr debugger</title>

		<link href="/assets/admin/bootstrap.min.css" rel="stylesheet">
		<link href="/assets/admin/style.css" rel="stylesheet">
		<link href="/assets/admin/jquery.jsonview.css" rel="stylesheet">

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body>
  		
  		<div class="json">
  			<div class="json-query">
  				<h4>Query</h4>
  				<div class="json-data">
  					
  				</div>
  			</div>
  			<div class="json-response">
  				<h4>Reponse</h4>
  				<div class="json-data">
  					
  				</div>
  			</div>
  		</div>

		<div class="query">
			<div class="loading js-loading">
				<div class="spinner">
					<div class="bounce1"></div>
					<div class="bounce2"></div>
					<div class="bounce3"></div>
				</div>
			</div>
			<div>
				<div class="row">
					<div class="col-md-12">
						<h5>Last query</h5>
						<p>
			  				<strong>last path</strong> <code class="js-lastpath"></code><br>
			  				<strong>last method</strong> <code class="js-lastmethod"></code><br>
			  				<strong>response status</strong> <code class="js-status"></code><br>
			  				<strong>actual token</strong> <code class="js-token">nope</code>
						</p>
		  			</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<h5>Routes</h5>
						<div class="bs-component">
							<ul class="nav nav-tabs js-tabs">
							</ul>
							<div id="myTabContent" class="tab-content js-tabscontent">
							</div>
								
						</div>
					</div>
				</div>
			</div>
		</div>
	
		<script> var BASE_PATH = "<?= url(); ?>/api"; </script>
	    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	    <script src="/assets/admin/bootstrap.min.js"></script>  
	    <script src="/assets/admin/jquery.jsonview.js"></script>  
	    <script src="/assets/admin/app.js"></script>  

	</body>
</html>