@extends('layouts.app')
 
@section('content')
    
    <?php
        if(isset($_GET['email'])){
            try{
                $mailchimp = app('Mailchimp');
                $mailchimp->lists->subscribe('1dd0c5eac8',  ['email' => $_GET['email']]);
            } catch (\Mailchimp_List_AlreadySubscribed $e) {
                // do something
            } catch (\Mailchimp_Error $e) {
                // do something
            }
        }
    ?>

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Create an account</div>
                <div class="panel-body">
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

                    @if (isset($_GET['email']))
                    <div class="col-md-12">
                        <div class="alert alert-info">
                            <strong>Thank you !</strong> You are now subscribed to Kubby's mailing list. Now, you can register !
                        </div>
                    </div>
                    @endif
 
                    <form class="form-horizontal" role="form" method="POST" action="/account/register">
                        {!! csrf_field() !!}
                        
                        <div class="col-md-6 col-md-offset-4"><h5>Account informations</h5><br></div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">E-Mail Address</label>
                            <div class="col-md-6">
                                <?php 
                                    $email = old('email');
                                    if(isset($_GET['email'])){ $email = $_GET['email']; }
                                ?>
                                <input type="email" class="form-control" name="email" value="{{ $email }}">
                            </div>
                        </div>
 
                        <div class="form-group">
                            <label class="col-md-4 control-label">Password</label>
                            <div class="col-md-6">
                                <input type="password" class="form-control" name="password">
                            </div>
                        </div>
 
                        <div class="form-group">
                            <label class="col-md-4 control-label">Confirm Password</label>
                            <div class="col-md-6">
                                <input type="password" class="form-control" name="password_confirmation">
                            </div>
                        </div>

                        <div class="col-md-6 col-md-offset-4"><h5>What about you ?</h5><br></div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">First Name</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="first_name" value="{{ old('first_name') }}">
                            </div>
                        </div>
 
                        <div class="form-group">
                            <label class="col-md-4 control-label">Last Name</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="last_name" value="{{ old('last_name') }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Company</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="company" value="{{ old('company') }}">
                            </div>
                        </div>
 
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <p>After your subscription, you will be able to add Slack and Analytics accounts.</p>
                                <button type="submit" class="btn btn-primary">
                                    Register
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
 
@endsection