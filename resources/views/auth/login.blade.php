@extends('layouts.form')
 
@section('content')
	
	<div class="panel-heading"> 
       <h3 class="text-center m-t-10"> Connect to easeIn</h3>
    </div> 

					
	@if (count($errors) > 0)
	    <div class="alert alert-danger">
	        <strong>Whoops!</strong> There were some problems with your input.<br><br>
	        <ul>
	            @foreach ($errors->all() as $error)
	                <li>{{ $error }}</li>
	            @endforeach
	        </ul>
	    </div>
	@endif

	<form role="form" method="POST" action="/account/login">
	    {!! csrf_field() !!}

	    <div class="col-md-12">
		    <div class="form-group">
	            <label class="control-label">Email</label>
	        	<input type="email" class="form-control" name="email" value="{{ old('email') }}">
	    	</div>
    	</div>

	    <div class="col-md-12">
		    <div class="form-group">
	            <label class="control-label">Password</label>
			    <input type="password" class="form-control"  name="password" id="password">
			</div>
		</div>
		
		<div class="col-md-12">
			<div class="form-group ">
	            <label class="cr-styled">
	                <input type="checkbox" checked name="remember">
	                <i class="fa"></i> 
	                Remember me
	            </label>
	        </div>
        </div>
        
        <div class="col-md-6">
        	<a href="/account/register" class="text-button-align">Create an account</a>
        </div>
        <div class="col-md-6">
	        <div class="form-group text-right">
	            <button class="btn btn-primary w-md" type="submit">Log In</button><br>
	        </div>
	    </div>

	    <div class="clear"></div>

	</form>


@endsection