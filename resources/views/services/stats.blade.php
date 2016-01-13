@extends('layouts.app')

@section('content')

	<p class="lead">My Analytics accounts</p>
	<ul class="list-group">

		@if(count($services) == 0)
			<li class="list-group-item">No account added ! Start by importing a Google Analytics account.</li>
		@endif

		@if(count($services) > 0)
			@foreach($services as $service)
				<li class="list-group-item">
					{{ $service['var1'] }}
					<div class="btn-group pull-right">
						<a href="/me/service/{{ $service['id'] }}/delete" class="btn btn-default">Delete</a>
					</div>
                </li>
			@endforeach
		@endif

		<li class="list-group-item">
			<div class="btn-group" role="group">
				<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					Import an account
					<span class="caret"></span>
				</button>
				<ul class="dropdown-menu">
					<li><a href="/me/service/create/ga">Google Analytics</a></li>
					<li class="disabled"><a href="#">Mailchimp</a></li>
					<li class="disabled"><a href="#">Custom API</a></li>
					</ul>
			</div>
        </li>

    </ul>
@endsection