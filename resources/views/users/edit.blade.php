@extends('layouts.app')

@section('content')

	<div class="row">
		
		<div class="col-md-12">
	        <div class="panel panel-default">
	            <div class="panel-heading">Edit my account</div>
	            <div class="panel-body">

					<form class="form-horizontal" role="form" method="POST" action="/me/account">
					    {!! csrf_field() !!}
		
					    <div class="form-group">
	                        <label class="col-md-4 control-label">First name</label>
	                        <div class="col-md-6">
				        		<input type="text" class="form-control" name="first_name" value="{{ $user['first_name'] }}">
				    		</div>
				    	</div>

					    <div class="form-group">
	                        <label class="col-md-4 control-label">Last name</label>
	                        <div class="col-md-6">
						        <input type="text" class="form-control"  name="last_name" value="{{ $user['last_name'] }}">
						    </div>
						</div>

						<div class="form-group">
	                        <label class="col-md-4 control-label">Company</label>
	                        <div class="col-md-6">
						        <input type="text" class="form-control"  name="company" value="{{ $user['company'] }}">
						    </div>
						</div>

						<div class="form-group">
	                        <label class="col-md-4 control-label">Email</label>
	                        <div class="col-md-6">
						        <input type="text" class="form-control"  name="email" value="{{ $user['email'] }}">
						    </div>
						</div>

					    <div class="form-group">
	                        <div class="col-md-6 col-md-offset-4">
	                            <button type="submit" class="btn btn-primary">
	                                Edit my account
	                            </button>
	                        </div>
	                    </div>
					</form>

	            </div>
	       	</div>
	    </div>
	</div>

@endsection