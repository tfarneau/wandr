@extends('layouts.app')

@section('content')
	
	<div class="modal fade" id="errorsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="exampleModalLabel">Errors creating generator</h4>
	      </div>
	      <div class="modal-body js-modalbody"></div>
	      <div class="modal-body js-modalbodysuccess" style="display:none;">
	      	@if(!isset($generator))
		      	<h4>Generator created !</h4>
		      	<p>Your generator was successfully created, and is now activated. Your will receive your first report soon !</p>
		      	<a href="/me/dashboard" class="btn btn-primary">Go to my dashboard</a>
	      	@else
	      		<h4>Generator edited  !</h4>
		      	<p>Your generator was successfully edited !</p>
		      	<a href="/me/dashboard" class="btn btn-primary">Go to my dashboard</a>
	      	@endif
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	      </div>
	    </div>
	  </div>
	</div>

	<div class="row">
		<form role="form" method="POST" action="/api/generator/save" class="js-mainform">
			{!! csrf_field() !!}

			@if(isset($generator))
				<input type="hidden" name="id" value="{{ $generator['id'] }}">
			@endif
			
			 <div class="col-md-12">

		        <div class="panel panel-default">
		            <div class="panel-heading">Create a report</div>
		            <div class="panel-body">

		            	<div class="col-md-12">
							<p>Hey there ! Lorem ipsum dolor sit amet, consectetur adipisicing elit. Atque exercitationem, nesciunt magni itaque ratione molestias sint laboriosam quas quod. Illum impedit totam amet officiis fuga, cumque cupiditate tenetur error maiores non suscipit soluta eos iusto molestias quisquam deleniti? Animi necessitatibus, maxime nobis voluptate enim a eius delectus ducimus id architecto repudiandae nisi, nesciunt laboriosam suscipit nam deserunt ratione iste asperiores.</p>
							<hr>
						</div>
					
						<div class="col-md-6">
							<div class="form-group">
		                        <label class="control-label">First, give a name to your report :</label>
					        	<input type="text" class="form-control js-channel" name="name" value="{{ isset($generator) ? $generator['name'] : null }}">
					        	<p class="help-block">This name will be use in your generators list.</p>
					    	</div>
					    </div>

					    <div class="col-md-6">
							<div class="form-group">
		                        <label class="control-label">Can you tell us who will see the reports ?</label>
					        	<input type="text" class="form-control js-channel" name="whosee" value="{{ isset($generator) ? $generator['whosee'] : null }}">
					        	<p class="help-block">This field is optionnal, but it helps us to improve the service.</p>
					    	</div>
					    </div>

					</div>
				</div>
			</div>
			

		    <div class="col-md-12">

		        <div class="panel panel-default">
		            <div class="panel-heading">Analytics configuration</div>
		            <div class="panel-body">
		            	<div class="col-md-12">
		            		<a href="#" class="js-force">Your website is not here ? Resync your Google Analytics accounts</a><br><br>
		            	</div>
						
						<div class="panel-loader js-galoader js-loader">
			            	<div class="sk-fading-circle">
								<div class="sk-circle1 sk-circle"></div>
								<div class="sk-circle2 sk-circle"></div>
								<div class="sk-circle3 sk-circle"></div>
								<div class="sk-circle4 sk-circle"></div>
								<div class="sk-circle5 sk-circle"></div>
								<div class="sk-circle6 sk-circle"></div>
								<div class="sk-circle7 sk-circle"></div>
								<div class="sk-circle8 sk-circle"></div>
								<div class="sk-circle9 sk-circle"></div>
								<div class="sk-circle10 sk-circle"></div>
								<div class="sk-circle11 sk-circle"></div>
								<div class="sk-circle12 sk-circle"></div>
							</div>
						</div>

		            	<div class="col-md-3">
		            		<label class="control-label">Select an Analytics service</label>
		            		<div class="list-group js-analyticsservices"></div>
							<input type="hidden" name="ga_service_id" value="{{ isset($generator) ? $generator['ga_service_id'] : null }}">
		            	</div>
		            	<div class="col-md-3">
		            		<label class="control-label">... an account</label>
		            		<div class="list-group js-analyticsaccounts">
							</div>
							<input type="hidden" name="ga_account" value="{{ isset($generator) ? $generator['ga_account'] : null }}">
		            	</div>
		            	<div class="col-md-3">
		            		<label class="control-label">... a property</label>
		            		<div class="list-group js-analyticsproperties"></div>
							<input type="hidden" name="ga_property" value="{{ isset($generator) ? $generator['ga_property'] : null }}">
		            	</div>
		            	<div class="col-md-3">
		            		<label class="control-label">... and a profile !</label>
		            		<div class="list-group js-analyticsprofiles"></div>
							<input type="hidden" name="ga_profile" value="{{ isset($generator) ? $generator['ga_profile'] : null }}">
		            	</div>
					</div>
				</div>
			</div>

			<div class="col-md-12">

		        <div class="panel panel-default">
		            <div class="panel-heading">Slack configuration</div>
		            <div class="panel-body">
						
						<div class="panel-loader js-slackloader js-loader">
			            	<div class="sk-fading-circle">
								<div class="sk-circle1 sk-circle"></div>
								<div class="sk-circle2 sk-circle"></div>
								<div class="sk-circle3 sk-circle"></div>
								<div class="sk-circle4 sk-circle"></div>
								<div class="sk-circle5 sk-circle"></div>
								<div class="sk-circle6 sk-circle"></div>
								<div class="sk-circle7 sk-circle"></div>
								<div class="sk-circle8 sk-circle"></div>
								<div class="sk-circle9 sk-circle"></div>
								<div class="sk-circle10 sk-circle"></div>
								<div class="sk-circle11 sk-circle"></div>
								<div class="sk-circle12 sk-circle"></div>
							</div>
						</div>

						<div class="col-md-4">
		            		<label class="control-label">Select your slack service</label>
		            		<div class="list-group js-slackservices"></div>
		            		<input type="hidden" name="slack_service_id" value="{{ isset($generator) ? $generator['slack_service_id'] : null }}">
						</div>

				    	<div class="col-md-4">
					    	<div class="form-group">
		                        <label class="control-label">Channel(s) to post</label>
					        	<input type="text" class="form-control js-channel" name="slack_channel" value="{{ isset($generator) ? $generator['slack_channel'] : null }}">
					        	<p class="help-block">List of slack channels, comma separated</p>
					    	</div>
					    </div>
						
						<div class="col-md-4">
					    	<div class="form-group">
					    	<label class="control-label">Test slack connection ?</label><br>
					        	<a href="#" class="btn btn-default js-testslack is-active btn-form">Send a test message</a>
					        	<p class="help-block">Send a test message to the slack channel(s)</p>
					    	</div>
						</div>
					</div>
				</div>

			</div>
			<div class="col-md-12">
				
				<div class="panel panel-default">
		            <div class="panel-heading">Report's template</div>
		            <div class="panel-body">

						<div class="col-md-8">
							<div class="form-group">
					        	<textarea name="template" class="form-control js-reportcontent report-text" rows="10"><?= isset($generator) ? $generator['template'] : 'New sessions : @{{ga:sessions}}'; ?></textarea>
					    	</div>
					    	<div class="col-md-6 nopadding-right date-select">
					    		<div class="form-group">
			                        <select class="form-control" name="end_date">
			                        	<?php
						        			$end_dates = [
						        				['','From date ...'],
						        				['yesterday','Yesterday'],
						        				['2daysAgo','2 days ago'],
						        				['3daysAgo','3 days ago'],
						        				['4daysAgo','4 days ago'],
						        				['5daysAgo','5 days ago'],
						        				['6daysAgo','6 days ago'],
						        				['7daysAgo','7 days ago'],
						        				['14daysAgo','14 days ago'],
						        				['21daysAgo','21 days ago'],
						        				['30daysAgo','30 days ago'],
						        				['60daysAgo','60 days ago'],
						        				['90daysAgo','90 days ago']
						        			];
						        		?>
										@foreach($end_dates as $d)
						        			<option value="{{ $d[0] }}" <?= isset($generator) && $d[0] == $generator['end_date'] ? 'selected' : null; ?>>{{ $d[1] }}</option>
						        		@endforeach
									</select>
									<p class="help-block">Get data from this date ...</p>
						    	</div>
						    </div>
						    <div class="col-md-6 nopadding-left date-select">
					    		<div class="form-group">
						        	<select class="form-control" name="start_date">
						        		<?php
						        			$start_dates = [
						        				['','... to date'],
						        				['today','Today'],
						        				['yesterday','Yesterday'],
						        				['3daysAgo','3 days ago'],
						        				['7daysAgo','7 days ago'],
						        				['14daysAgo','14 days ago'],
						        				['30daysAgo','30 days ago'],
						        			];
						        		?>
						        		@foreach($start_dates as $d)
						        			<option value="{{ $d[0] }}" <?= isset($generator) && $d[0] == $generator['start_date'] ? 'selected' : null; ?>>{{ $d[1] }}</option>
						        		@endforeach
									</select>
									<p class="help-block">... to this date</p>
						    	</div>
						    </div>
						</div>

						<div class="col-md-4">
							
							<div class="list-group list-group-small">
								<div class="list-group-item">
									<input type="text" class="form-control js-livesearch" data-filter="metric" placeholder="Metrics">
								</div>
								@foreach($metas as $meta)
									@if($meta->attributes->type == "METRIC" && $meta->attributes->status != "DEPRECATED")
										<div class="list-group-item js-filtermetric js-metric" data-value="{{ $meta->id }}">
											<h6 class="list-group-item-heading">{{ $meta->attributes->uiName }}</h6>
											<p class="list-group-item-text">{{ $meta->id }}</p>
										</div>
									@endif
								@endforeach
							</div>

							<div class="list-group list-group-small">
								<div class="list-group-item">
									<input type="text" class="form-control js-livesearch" data-filter="dim" placeholder="Dimension">
								</div>
								@foreach($metas as $meta)
									@if($meta->attributes->type == "DIMENSION" && $meta->attributes->status != "DEPRECATED")
										<div class="list-group-item js-filterdim js-dimension" data-value="{{ $meta->id }}">
											<h6 class="list-group-item-heading">{{ $meta->attributes->uiName }}</h6>
											<p class="list-group-item-text">{{ $meta->id }}</p>
										</div>
									@endif
								@endforeach
							</div>

							<a href="#" class="btn btn-default btn-full js-addassitantfields pull-right">Add to my report</a>

						</div>

	                </div>
	            </div>
	        </div>
	        <div class="col-md-12">

		        <div class="panel panel-default">
		            <div class="panel-heading">Report's hours</div>
		            <div class="panel-body">
						
						<div class="col-md-12">
		            		<label class="control-label">Hours to trigger ?</label>
							<div class="btn-group btn-times">
								@for($i=0;$i<=23;$i++)
									<a class="btn btn-default js-date" data-name="activation_hours" data-value="{{ $i }}">{{ $i }}</a>
								@endfor
								<div class="clear"></div>
							</div>
							<input type="hidden" name="activation_hours">
						</div>

						<?php
							$days = array(
							    'Monday',
							    'Tuesday',
							    'Wednesday',
							    'Thursday',
							    'Friday',
							    'Saturday',
							    'Sunday'
							);
						?>

						<div class="col-md-12">
		            		<label class="control-label">Days to trigger ?</label>
							<div class="btn-group btn-times">
								@foreach($days as $kday => $day)
									<a class="btn btn-default js-date" data-name="activation_days" data-value="{{ $kday+1 }}">{{ $day }}</a>
								@endforeach
								<div class="clear"></div>
							</div>
							<input type="hidden" name="activation_days">
						</div>

					</div>
				</div>

			</div>

			<div class="col-md-12">

		        <div class="panel panel-default">
		            <div class="panel-body">
						
						<div class="col-md-12">
							@if(isset($generator))
								<button type="submit" class="btn btn-primary pull-right">Edit</button>
							@else
								<button type="submit" class="btn btn-primary pull-right">Add this report !</button>
							@endif
						</div>

					</div>
				</div>

			</div>
	        

		</form>
	</div>
	
@endsection

@section('scripts')
	<script>

		@if(isset($generator))
			var isEdit = true;
		@endif

		// Form submitting

		$('.js-mainform').on('submit', function(e){
			$.ajax({
	            url: $(this).attr('action'),
	            type: 'POST',
	            data: $(this).serialize(),
	            success: function(data) {

	            	if(data.status == "error"){
	            		$('.modal-header,.modal-footer').show();
	            		var html = "";
	            		for(var i in data.data){
	            			html += '<div class="alert alert-danger">';
	            			for(var j in data.data[i]){
	            				html += data.data[i][j]+"<br>";
	            			}
	            			html += '</div>';
	            		}
	            		$('.js-modalbody').html(html);
	            		$('#errorsModal').modal('show');
	            	}else{
	            		$('.modal-header,.modal-footer').hide();
	            		$('.js-modalbody').hide();
	            		$('.js-modalbodysuccess').show();
	            		$('#errorsModal').modal({
		            		backdrop: 'static'
		            	});
	            	}

	            }
	        });
			e.preventDefault();
		});

		// Days & hours click

		@if(isset($generator))
			var dates = {
				activation_days:"{{ $generator['activation_days'] }}".split(','),
				activation_hours:"{{ $generator['activation_hours'] }}".split(',')
			};

			for(var i in dates){
				$('input[name="'+i+'"]').val(dates[i]);
				for(var j in dates[i]){
					$('.js-date[data-name="'+i+'"]').filter(function() {
					    return $(this).attr('data-value') == dates[i][j];
					}).addClass('active');
				}
			}
		@else
			var dates = {
				activation_days:[],
				activation_hours:[]
			};
		@endif

		$('.js-date').on('click',function(){
			var type = $(this).attr('data-name');
			if($(this).hasClass('active')){
				$(this).removeClass('active');
				dates[type].splice(dates[type].indexOf($(this).attr('data-value')),1);
			}else{
				$(this).addClass('active');
				dates[type].push($(this).attr('data-value'));
			}
			$('input[name="'+type+'"]').val(dates[type].join(','));
		});

		// Assistant

		var assistant_fields = {
			metric : null,
			dimension : null
		};

		$('.js-addassitantfields').on('click',function(e){
			console.log(assistant_fields)
			var value = null;
			if(assistant_fields.metric !== null){
				value = assistant_fields.metric;
			}if(assistant_fields.metric !== null && assistant_fields.dimension !== null){
				value = assistant_fields.metric+"|"+assistant_fields.dimension;
			}

			if(value !== null){
				var content = $('.js-reportcontent').val();
				content = content+" \{\{"+value+"\}\} ";
				$('.js-reportcontent').val(content);
			}

			e.preventDefault();
		});

		$('.js-metric').on('click',function(){
			if($(this).hasClass('active')){
				$('.js-metric').removeClass('active');
				assistant_fields.metric = null;
			}else{
				$('.js-metric').removeClass('active');
				assistant_fields.metric = $(this).attr('data-value');
				$(this).addClass('active');
			}
		});

		$('.js-dimension').on('click',function(){
			if($(this).hasClass('active')){
				$('.js-dimension').removeClass('active');
				assistant_fields.dimension = null;
			}else{
				$('.js-dimension').removeClass('active');
				assistant_fields.dimension = $(this).attr('data-value');
				$(this).addClass('active');
			}
		});

		$('.js-livesearch').on('keyup',function(){
			var val = $(this).val();
			val = val.toLowerCase();
			var filter = $(this).attr('data-filter');
			if(val.length > 1){
				$('.js-filter'+filter).each(function(i,el){
					var text = $(el).text();
					text = text.toLowerCase();
					if(text.indexOf(val) != -1){
						$(el).show();
					}else{
						$(el).hide();
					}
				});
			}else{
				$('.js-filter'+filter).show();
			}
		});

		// Test slack button

		var slackTestTimer;
		$('.js-testslack').on('click',function(){
			if($(this).hasClass('is-active')){
				clearTimeout(slackTestTimer);
				$.get("/api/generators/actions/unforce/testslack/"+$('.js-slackservices').val()+"/"+$('.js-channel').val(), function(data){ console.log(data); });
				$(".js-testslack").removeClass('is-active');
				slackTestTimer=setTimeout(function(){
					$(".js-testslack").addClass('is-active');
				},2000);
			}
		});

		// Ga tree

		var first_run = false;
		var force_mode = "unforce";

		$('.js-force').one('click',function(){
			$(this).text('Resyncing Google Analytics accounts ...');
			force_mode = "force";

			$('.js-analyticsaccounts,.js-analyticsproperties,.js-analyticsprofiles').each(function(i,el){
				$(el).html('');
			});
			$('.js-analyticsservices,.js-analyticsaccounts,.js-analyticsproperties,.js-analyticsprofiles').each(function(i,el){
					$(el).find('a').removeClass('active');
					$(el).next('input').val('');
				});
			
			getServices();
		});

		function getProfiles(service,account,property){
			$.get("/api/generators/actions/"+force_mode+"/getprofiles/"+service+"/"+account+"/"+property, function(data) {
				var html = "";
				for(var i in data){ html += "<a href='#' class='list-group-item' data-value='"+data[i].id+"'>"+data[i].name+" ("+data[i].webPropertyId+")</a>"; }
				$('.js-analyticsprofiles').html(html);

				$('.js-analyticsprofiles a').bind('click',function(e){
					$('.js-analyticsprofiles').each(function(i,el){
						$(el).find('a').removeClass('active');
						$(el).next('input').val('');
					});
					$('input[name="ga_profile"]').val($(this).attr('data-value'));
					$(this).addClass('active'); e.preventDefault();
				});

				@if(isset($generator))
					if(!first_run){
						var actual_value = $('input[name="ga_profile"]').val();
						$('.js-analyticsprofiles a[data-value="'+actual_value+'"]').addClass('active');
						first_run = true;
					}else{
						$('.js-loader').hide();
					}
				@endif
				
				$('.js-loader').hide();
			});
		}

		function getProperties(service,account){
			$.get("/api/generators/actions/"+force_mode+"/getproperties/"+service+"/"+account, function(data) {
				var html = "";
				for(var i in data){ html += "<a href='#' class='list-group-item' data-value='"+data[i].id+"'>"+data[i].name+"</a>"; }
				$('.js-analyticsproperties').html(html);

				$('.js-analyticsproperties a').unbind('click');
				$('.js-analyticsproperties a').bind('click',function(e){
					$('.js-analyticsprofiles').each(function(i,el){
						$(el).html('');
					});
					$('.js-analyticsproperties,.js-analyticsprofiles').each(function(i,el){
						$(el).find('a').removeClass('active');
						$(el).next('input').val('');
					});
					$('input[name="ga_property"]').val($(this).attr('data-value'));
					$('.js-galoader').show();
					$(this).addClass('active'); e.preventDefault();
					getProfiles(service,account,$(this).attr('data-value'));

				});

				@if(isset($generator))
					if(!first_run){
						var actual_value = $('input[name="ga_property"]').val();
						getProfiles(service,account,actual_value);
						$('.js-analyticsproperties a[data-value="'+actual_value+'"]').addClass('active');
					}else{
						$('.js-loader').hide();
					}
				@else
					$('.js-loader').hide();
				@endif
			});
		}

		function getAccounts(service){
			$.get("/api/generators/actions/"+force_mode+"/getaccounts/"+service, function(data) {
				var html = "";
				for(var i in data){ html += "<a href='#' class='list-group-item' data-value='"+data[i].id+"'>"+data[i].name+"</a>"; }
				$('.js-analyticsaccounts').html(html);

				$('.js-analyticsaccounts a').unbind('click');
				$('.js-analyticsaccounts a').bind('click',function(e){
					$('.js-analyticsproperties,.js-analyticsprofiles').each(function(i,el){
						$(el).html('');
					});
					$('.js-analyticsaccounts,.js-analyticsproperties,.js-analyticsprofiles').each(function(i,el){
						$(el).find('a').removeClass('active');
						$(el).next('input').val('');
					});
					$('input[name="ga_account"]').val($(this).attr('data-value'));
					$('.js-galoader').show();
					$(this).addClass('active'); e.preventDefault();
					getProperties(service,$(this).attr('data-value'));

				});

				@if(isset($generator))
					if(!first_run){
						var actual_value = $('input[name="ga_account"]').val();
						getProperties(service,actual_value);
						$('.js-analyticsaccounts a[data-value="'+actual_value+'"]').addClass('active');
					}else{
						$('.js-loader').hide();
					}
				@else
					$('.js-loader').hide();
				@endif
			});
		}

		function getServices(){

			$.get("/api/generators/actions/"+force_mode+"/getservices", function(data) {
				var htmlAnalytics = "";
				var htmlSlack = "";
				for(var i in data){ 
					if(data[i].slug == "ga"){
						htmlAnalytics += "<a href='#' class='list-group-item' data-value='"+data[i].id+"'>"+data[i].var1+"</a>"; 
					}else if(data[i].slug == "slack"){
						htmlSlack += "<a href='#' class='list-group-item' data-value='"+data[i].id+"'>"+data[i].var1+"</a>"; 
					}

				}
				$('.js-analyticsservices').html(htmlAnalytics);
				$('.js-slackservices').html(htmlSlack);

				$('.js-analyticsservices a').unbind('click');
				$('.js-analyticsservices a').bind('click',function(e){
					$('.js-analyticsaccounts,.js-analyticsproperties,.js-analyticsprofiles').each(function(i,el){
						$(el).html('');
					});
					$('.js-analyticsservices,.js-analyticsaccounts,.js-analyticsproperties,.js-analyticsprofiles').each(function(i,el){
						$(el).find('a').removeClass('active');
						$(el).next('input').val('');
					});
					$('input[name="ga_service_id"]').val($(this).attr('data-value'));
					$('.js-galoader').show();
					$(this).addClass('active'); e.preventDefault();
					getAccounts($(this).attr('data-value'));

				});

				$('.js-slackservices a').unbind('click');
				$('.js-slackservices a').bind('click',function(e){
					$('input[name="slack_service_id"]').val($(this).attr('data-value'));
					$(this).addClass('active'); e.preventDefault();
				});

				@if(isset($generator))
					if(!first_run){
						var actual_value = $('input[name="ga_service_id"]').val();
						getAccounts(actual_value);
						$('.js-analyticsservices a[data-value="'+actual_value+'"]').addClass('active');

						var actual_value2 = $('input[name="slack_service_id"]').val();
						$('.js-slackservices a[data-value="'+actual_value2+'"]').addClass('active');
					}else{
						$('.js-loader').hide();
					}
				@else
					$('.js-loader').hide();
				@endif
			});

		}

		getServices();


	</script>
@endsection