@extends('layouts.app')

@section('title', 'Homepage')

@section('top_content')

	<div class="wrapper-home">
        <div class="container">
            <div class="col-md-12 headline-container">
            <img src="/images/logo.png" alt="logo" class="logo">
                <h1>Slackreports</h1>
                <h2>Automatic Google Analytics reports directly in Slack. 100% free.</h2>
                <p>
                    <a class="btn btn-default btn-lg" href="/account/login">Login</a>
                    <a class="btn btn-primary btn-lg" href="/account/register">Create an account</a>
                </p>
            </div>
        </div>   
    </div>
    <div class="container">
        <div class="col-md-12 home-arg">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="col-md-3">
                        <img src="/images/love.png" alt="">
                    </div>
                    <div class="col-md-9">
                        <p class="lead">Unlimited Slack team, Google accounts, and reports generators</p>
                        <p>You can import all your Google accounts & Slack teams, and create as many reports as you want. You can, for exemple, setup a hourly summary of sessions, and a weekly overview of your best referrals.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 home-arg">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="col-md-6">
                        <p class="lead">Create unique reports, with 300+ metrics and dimensions usable via a wizard</p>
                        <p>You can use Google Analytics metrics (such as sessions and users), but also dimensions (for exemple, referrals). This allow you to create a very large number of combination (more than a thousand), like the number of returning user by referral, for example.</p>
                        <p>A wizard helps you to find the good metric and the good dimension. You can also choose the date range of the report : get the data of today, of the 3 last days, on the last week ...</p>
                        <p>Convinced ? <a href="#">create an account !</a></p>
                    </div>
                    <div class="col-md-6">
                        <img src="/images/report.png" alt="">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 home-arg">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="col-md-12">
                        <p class="lead">Choose what day and what time publish the report, improve your productibity and motivate your team</p> 
                        <p>You can easily choose when the report have to be published. Publishing your stats in Analytics is a good way to motivate your team and keep an eye on your KPIs !</p><br>
                        <img src="/images/hours.png" alt="">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 home-arg">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="col-md-12 text-align-center">
                        <a class="btn btn-default" href="/account/login">Login</a>
                        <a class="btn btn-primary" href="/account/register">Create an account</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop