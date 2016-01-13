@extends('layouts.app')

@section('content')
	
	<div class="row">

		@if($slug == "slack")
			
			<div class="col-md-12">
		        <div class="panel panel-default">
		            <div class="panel-heading">Import a Slack team</div>
		            <div class="panel-body">

						<form class="form-horizontal" role="form" method="POST" action="/me/service/add/slack">
						    {!! csrf_field() !!}
			
						    <div class="form-group">
		                        <label class="col-md-4 control-label">Team's name</label>
		                        <div class="col-md-6">
					        		<input type="text" class="form-control" name="var1" value="{{ old('var1') }}">
					        		<p class="help-block">This field is only used to store the team. Your can name it differently from the real name of your team.</p>
					    		</div>
					    	</div>

						    <div class="form-group">
		                        <label class="col-md-4 control-label">Incoming Webhook url</label>
		                        <div class="col-md-6">
							        <input type="text" class="form-control"  name="var2" value="{{ old('var2') }}">
							        <p class="help-block">Create a <a href="https://slack.com/services/new/incoming-webhook" target="_blank">incoming webhook</a> for the team your want, and copy-paste the generated url.</p>
							    </div>
							</div>

						    <div class="form-group">
		                        <div class="col-md-6 col-md-offset-4">
		                            <button type="submit" class="btn btn-primary">
		                                Import my Slack team
		                            </button>
		                        </div>
		                    </div>
						</form>

		            </div>
		       	</div>
		    </div>
		    <div class="col-md-12">
				<h5>Do you store Slack messages ?</h5>
				<p>No, incoming webhooks only allow us to send message to Slack, not to read messages from Slack.</p>
				<h5>How to create a Incoming Webhook ?</h5>
				<p>Go to  <a href="https://slack.com/services/new/incoming-webhook" target="_blank">this page</a> select the team/channel you want, and copy-paste the generated code into our "Incoming Webhook url" field.</p>
		    </div>

		@endif

		@if($slug == "ga")
			
			<div class="col-md-8">
		        <div class="panel panel-default">
		            <div class="panel-heading">Import a Google Analytics account</div>
		            <div class="panel-body">
						
						<div class="col-md-12">
							
							<p>Connect to your Google account to import it.</p>
							<p><em>No metric or statical data is stored or communicated. All your data is yours and remains in your Analytics account.</em></p>
							<br>
							<form class="form-horizontal" role="form" method="POST" action="/me/service/add/ga">
							    {!! csrf_field() !!}

							    <div class="form-group">
			                        <div class="col-md-12">
			                            <button type="submit" class="btn btn-primary">
			                                Connect with my Google account
			                            </button>
			                        </div>
			                    </div>
							</form>
						</div>

		            </div>
		       	</div>
		    </div>
		    <div class="col-md-4">
				<h5>Are my metrics stored ?</h5>
				<p>No, no metric or statical data is stored or communicated. All your data is yours and remains in your Analytics account.</p>
				<h5>Are my reports stored ?</h5>
				<p>No, reports are only sent to your Slack account. No copy is stored.</p>
				<h5>Can I easily delete your access to my analytics ?</h5>
				<p>Yes, you only have to delete Slackreport from your applications on your Google account.</p>
		    </div>

		@endif

	</div>

@endsection