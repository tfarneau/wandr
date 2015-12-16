<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="">

		<title>Wandr simulator</title>

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
  		
  		<div class="container">

  			<div class="row js-step1-block js-step">
  				<div class="col-md-12">
	  				<div class="page-header">
	  					<h3>1/ Login</h3>
	  				</div>
	  			</div>
	  			<div class="col-md-12 well">
	  				<form class="js-step1">
						
						<div class="col-md-4">
							<div class="form-group">
								<input type="text" class="form-control" name="email" placeholder="Email" value="chris@scotch.io">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<input type="text" class="form-control" name="password" placeholder="Password" value="secret">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<button type="submit" class="btn btn-primary">Submit</button>
							</div>
						</div>

					</form>
					
					<div class="col-md-12" style="margin-bottom: 15px;">
						<span class="js-step1-status">Not completed</span>
					</div>

	  			</div>
  			</div>

  			<div class="row js-step2-block js-step">
  				<div class="col-md-12">
	  				<div class="page-header">
	  					<h3>2/ Choose point</h3>
	  				</div>
	  			</div>
	  			<div class="col-md-12 well">
	  				<form class="js-step2">
						
						<div class="col-md-4">
							<div class="form-group">
								<input type="text" class="form-control" name="lat" placeholder="Latitude" value="48.8388423">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<input type="text" class="form-control" name="lng" placeholder="Longitude" value="2.4149193">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<input type="text" class="form-control" name="time" placeholder="Temps en minutes" value="40">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<input type="text" class="form-control" name="mode" placeholder="Mode (bike/foot)" value="foot">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<input type="text" class="form-control" name="type" placeholder="Type (classic/sport)" value="sport">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<button type="submit" class="btn btn-primary">Submit</button>
							</div>
						</div>

					</form>

					<div class="col-md-12" style="margin-bottom: 15px;">
						<span class="js-step2-status">Warning</span>
					</div>

	  			</div>
  			</div>

  			<div class="row js-step3-block js-step">
  				<div class="col-md-12">
	  				<div class="page-header">
	  					<h3>3/ Select checkpoints</h3>
	  				</div>
	  			</div>
				<div class="col-md-12 well">
					<div class="js-checkpoints"></div>
					<div class="col-md-12" style="margin: 20px 0;"><a href="#" class="btn btn-default js-step3">Calculate itinerary</a></div>
	  			</div>
  			</div>

  			<div class="row js-step4-block js-step">
  				<div class="col-md-12">
	  				<div class="page-header">
	  					<h3>4/ Show itineraries</h3>
	  				</div>
	  			</div>
	  			<div class="col-md-12 well">
	  				<div id="map-canvas"></div>
	  			</div>
  			</div>

  		</div>

  		<script> var BASE_PATH = "<?= url(); ?>/api"; </script>
		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBryNx9i0f-P2SYSLOsMm5ha10jaHL72HE"></script>
	    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	    <script src="/assets/admin/bootstrap.min.js"></script>  
	    <script src="/assets/admin/simulator.js"></script>  

	</body>
</html>