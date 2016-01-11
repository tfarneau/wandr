@extends('layouts.app')
 
@section('content_header')

	<div class="row">
		<div class="col-md-12">
			<h4>Welcome {{ Auth::user()->first_name }} !</h4>
			<p>@if(count($slack_services) == 0 OR count($ga_services) == 0) Firstly, import a Slack team and a Google Analytics account ! @endif</p>
		</div>
	</div>

@endsection

@section('content')

	<div class="row">
		@if(count($slack_services) == 0 OR count($ga_services) == 0)
			<div class="col-md-12">

				<div class="well">
					<p><strong>Welcome there !</strong> You haven't added any Slack team or Google Analytic account.</p>
					<p>First, you have to <a href="/me/service/create/slack">import a Slack team</a>, and <a href="/me/service/create/ga">import a Google Analytics account</a>. Then, you will be able to <a href="/me/generator/create">create a generator</a>, which will help you to create automatic reports. Be sure that your reports and your data will not be stored !</p>
				</div>

			</div>
		@endif

		<div class="col-md-6">
		 	<div class="panel panel-default">
		        <div class="panel-heading">My Slack teams</div>
	            <div class="panel-body">
	            	<div class="col-md-12">
						<ul class="list-group">

							@if(count($slack_services) == 0)
								<li class="list-group-item">No account added ! Start by importing a Slack team.</li>
							@endif

							@if(count($slack_services) > 0)
								@foreach($slack_services as $slack_service)
									<li class="list-group-item">
										{{ $slack_service['var1'] }}
										<div class="btn-group pull-right">
											<a href="/me/service/{{ $slack_service['id'] }}/delete" class="btn btn-default">Delete</a>
										</div>
					                </li>
								@endforeach
							@endif

							<li class="list-group-item">
								<a href="/me/service/create/slack" class="btn btn-primary">Import a Slack team</a>
			                </li>

			            </ul>
					</div>
	           	</div>
		    </div>
		</div>

		<div class="col-md-6">
			<div class="panel panel-default">
		        <div class="panel-heading">My Google Analytics accounts</div>
	            <div class="panel-body">
	            	<div class="col-md-12">
	            		<ul class="list-group">

							@if(count($ga_services) == 0)
								<li class="list-group-item">No account added ! Start by importing a Google Analytics account.</li>
							@endif

							@if(count($ga_services) > 0)
								@foreach($ga_services as $ga_service)
									<li class="list-group-item">
										{{ $ga_service['var1'] }}
										<div class="btn-group pull-right">
											<a href="/me/service/{{ $ga_service['id'] }}/delete" class="btn btn-default">Delete</a>
										</div>
					                </li>
								@endforeach
							@endif

							<li class="list-group-item">
								<a href="/me/service/create/ga" class="btn btn-primary">Import a Google Analytics account</a>
			                </li>

			             </ul>
	            	</div>
	            </div>
	        </div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
		        <div class="panel-heading">My generators</div>
	            <div class="panel-body">
	            	<div class="col-md-12">
	            		<ul class="list-group">
			                @if(count($generators) == 0)
								<li class="list-group-item">No generator added !</li>
							@endif

							@if(count($generators) > 0)
								@foreach($generators as $generator)
									<li class="list-group-item">
										{{ $generator['name'] }}
										
										@if($generator['is_active'] == 1)
											<span class="label label-info active-status">Active</span>
										@else
											<span class="label label-danger active-status">Unactive</span>
										@endif

										<?php $hours = explode(',',$generator['activation_hours']); ?>
										@foreach($hours as $h)
											<span class="label label-success">{{ $h }}h</span>
										@endforeach

										<?php $days = explode(',',$generator['activation_days']); ?>
										<?php
											$days_array = array(
											    'Monday',
											    'Tuesday',
											    'Wednesday',
											    'Thursday',
											    'Friday',
											    'Saturday',
											    'Sunday'
											);
										?>

										@foreach($days as $d)
											<span class="label label-success">{{ $days_array[$d-1] }}</span>
										@endforeach

										<div class="btn-group pull-right">
											@if($generator['is_active'] == 1)
												<a href="/me/generator/{{ $generator['id'] }}/unactivate" class="btn btn-default">Unactivate</a>
											@else
												<a href="/me/generator/{{ $generator['id'] }}/activate" class="btn btn-default">Activate</a>
											@endif
											<a href="/me/generator/{{ $generator['id'] }}/edit" class="btn btn-default">Edit</a>
											<a href="/me/generator/{{ $generator['id'] }}/test" class="btn btn-default">Test now</a>
										</div>
					                </li>
								@endforeach
							@endif

							<li class="list-group-item">
								<a href="/me/generator/create" class="btn btn-primary">Create a generator</a>
			                </li>
			             </ul>
	            	</div>
	            </div>
	        </div>
	    </div>
	</div>
@endsection