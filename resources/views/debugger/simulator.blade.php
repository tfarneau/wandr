<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="">

		<title>Wandr simulator</title>

		<link href="/assets/admin/bootstrap.min.css" rel="stylesheet">
		<link href="/assets/admin/simulator.css" rel="stylesheet">

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body>
  		

		<div class="container js-step1-block js-step step gone">
			<div class="row">
				<div class="row-content">
		  			<div class="col-md-12">
		  				<div class="page-header">
		  					<h3>Connexion</h3>
		  				</div>
		  				<div class="page-content">
		  					<div class="col-md-12">
		  						<p>Commencez par vous connecter avec un compte utilisateur.</p>
		  					</div>
			  				<form class="js-step1">
								
								<div class="col-md-5">
									<div class="form-group">
										<input type="text" class="form-control" name="email" placeholder="Email" value="chris@scotch.io">
									</div>
								</div>
								<div class="col-md-5">
									<div class="form-group">
										<input type="text" class="form-control" name="password" placeholder="Password" value="secret">
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<button type="submit" class="btn btn-primary">Connexion</button>
									</div>
								</div>

							</form>
							
							<div class="col-md-12" style="margin-bottom: 15px;  display: none;">
								<span class="js-step1-status">Not completed</span>
							</div>

							<div class="u-clear"></div>

						</div>
		  			</div>
		  		</div>
		  	</div>
		</div>

		<div class="container js-step2-block js-step step gone">
			<div class="row">
				<div class="row-content">
		  			<div class="col-md-12">
		  				<div class="page-header">
		  					<h3>Choisissez votre position</h3>
		  				</div>
		  				<div class="page-content">
				  			<div class="col-md-12" style="margin-bottom: 15px;">
				  				<form class="js-step2">

				  					<div id="point-map" style="margin-top: 10px; margin-bottom: 20px;"></div>
									
									<div class="col-md-6">
										<div class="form-group">
											<label>Latitude</label>
											<input type="text" class="form-control js-pointlat" name="lat" placeholder="Latitude" id="latitude" value="48.8388423">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>Longitude</label>
											<input type="text" class="form-control js-pointlng" name="lng" placeholder="Longitude" value="2.4149193">
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label>Temps en minutes</label>
											<input type="text" class="form-control" name="time" placeholder="Temps en minutes" value="100">
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label>Mode</label>
											<select class="form-control" name="mode">
												<option value="foot">À pieds</option>
												<option value="bike">En vélo</option>
											</select>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label>Type</label>
											<select class="form-control" name="type">
												<option value="classic">Promenade</option>
												<option value="sport" selected="selected">Sport</option>
											</select>
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group">
											<button type="submit" class="btn btn-primary">Envoyer</button>
										</div>
									</div>

								</form>

								<div class="col-md-12" style="margin-bottom: 15px; display: none;">
									<span class="js-step2-status">Warning</span>
								</div>

				  			</div>
				  		</div>
			  		</div>
			  	</div>
			</div>
		</div>
		
		<div class="container js-step3-block js-step step gone">
			<div class="row">
				<div class="row-content">
		  			<div class="col-md-12">
		  				<div class="page-header">
		  					<h3>Choisissez votre position</h3>
		  				</div>
		  				<div class="page-content">
				  			<div class="col-md-12" style="margin-bottom: 15px; margin-top: 15px;">
								<p>Choisissez vos points de passage en cliquant dessus. Séléctionnez-en plusieurs pour multiplier les possibilités !</p>	
							</div>
							<div class="js-checkpoints"></div>
							<div class="col-md-12" style="margin: 20px 0;">
								<a href="#" class="btn btn-default js-step3">Calculate itinerary</a>
							</div>
				  			</div>
				  		</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="container js-step4-block js-step step gone">
			<div class="row">
				<div class="row-content">
		  			<div class="col-md-12">
		  				<div class="page-header">
		  					<h3>Voila votre itinéraire !</h3>
		  				</div>
		  				<div class="page-content">
				  			<div class="col-md-12" style="margin-bottom: 15px;">
  								<div id="map-canvas" style="margin-top: 10px;"></div>
  								<p style="margin: 25px 0;">
  									<strong>Distance totale :</strong> <span class="js-metadistance"></span> /
  									<strong>Temps total :</strong> <span class="js-metatime"></span>
  								</p>
  								<h4 style="margin-bottom: 25px;">Checkpoints séléctionnés</h4>
  								<div class="js-checkpoints2"></div>
				  			</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="loading js-loading">
			<div class="spinner">
				<div class="bounce1"></div>
				<div class="bounce2"></div>
				<div class="bounce3"></div>
			</div>
		</div>


  		<script> var BASE_PATH = "<?= url(); ?>/api"; </script>
		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBryNx9i0f-P2SYSLOsMm5ha10jaHL72HE"></script>
	    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	    <script src="/assets/admin/bootstrap.min.js"></script>  
	    <script src="/assets/admin/simulator.js"></script>  

	</body>
</html>