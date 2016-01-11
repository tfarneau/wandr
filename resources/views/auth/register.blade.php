@extends('layouts.form')
 
@section('content')
    
    <div class="panel-heading"> 
       <h3 class="text-center m-t-10"> Create an account</h3>
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

    <form role="form" method="POST" action="/account/register">
        {!! csrf_field() !!}
        
        <div class="col-md-12">
            <div class="form-group">
                <label class="control-label">First Name</label>
                <input type="text" class="form-control" name="first_name" value="{{ old('first_name') }}">
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label class="control-label">Last Name</label>
                <input type="text" class="form-control" name="last_name" value="{{ old('last_name') }}">
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label class="control-label">E-Mail Address</label>
                <input type="email" class="form-control" name="email" value="{{ old('email') }}">
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label class="control-label">Password</label>
                <input type="password" class="form-control" name="password">
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label class="control-label">Confirm Password</label>
                <input type="password" class="form-control" name="password_confirmation">
            </div>
        </div>

        
        <div class="col-md-6">
            <a href="/account/login" class="text-button-align">I already have an account</a>
        </div>
        <div class="col-md-6">
            <div class="form-group text-right">
                <button class="btn btn-primary w-md" type="submit">Register</button><br>
            </div>
        </div>

        <div class="clear"></div>

    </form>


@endsection


   