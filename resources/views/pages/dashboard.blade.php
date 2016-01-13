@extends('layouts.app')

@section('content')

	<div class="row">
		{{-- <div class="col-md-12">
			<p class="lead">My dashboard</p>
		</div> --}}
		<div class="col-md-3">
			<div class="panel panel-default panel-stats panel-stats-inverse">
				<div class="panel-body">
					<div class="number">{{ $count['reports'] }}</div>
					<div class="number-legend">Generated {{ str_plural('report', $count['reports']) }}</div>
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="panel panel-default panel-stats">
				<div class="panel-body">
					<div class="number">{{ $count['services_slack'] }}</div>
					<div class="number-legend">Slack {{ str_plural('team', $count['services_slack']) }}</div>
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="panel panel-default panel-stats">
				<div class="panel-body">
					<div class="number">{{ $count['services_stats'] }}</div>
					<div class="number-legend">Analytics {{ str_plural('account', $count['services_stats']) }}</div>
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="panel panel-default panel-stats">
				<div class="panel-body">
					<div class="number">{{ $count['generators'] }}</div>
					<div class="number-legend">{{ str_plural('Generator', $count['generators']) }}</div>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="panel panel-default">
	            <div class="panel-heading">How to ?</div>
	            <div class="panel-body help">
	            	<div class="col-md-3 number-container">
	            		<div class="number">1</div>
	            	</div>
	            	<div class="col-md-9">
	            		<h4>Import a Slack Team</h4>
	            		<p>First, click on the link "My Slack Teams", and on "Import a Slack team". Follow the instructions, and your Slack team will be imported. This team will be used for publishing the reports.</p>
	            	</div>
	            	<div class="clear"></div>
	            	<div class="col-md-3 number-container">
	            		<div class="number">2</div>
	            	</div>
	            	<div class="col-md-9">
	            		<h4>Import an Analytics account</h4>
	            		<p>Then, import an analytics account. Click on "My Analytics accounts", and click "Import an account". For now, you can only import a Google Analytics account, but soon, it will be possible to import other services accounts, like Mailchimp.</p>
	            	</div>
	            	<div class="clear"></div>
	            	<div class="col-md-3 number-container">
	            		<div class="number">3</div>
	            	</div>
	            	<div class="col-md-9">
	            		<h4>Create a generator</h4>
	            		<p>You can now create a generator. Click "My generators", and "Create a generator". Then, </p>
	            	</div>
	            </div>
	        </div>
        </div>
	</div>
@endsection