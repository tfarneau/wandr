@extends('layouts.app')

@section('content')

	<div class="row">

		<div class="col-md-12">
			<p class="lead">My Slack teams</p>
			<ul class="list-group">

				@if(count($services) == 0)
					<li class="list-group-item">No account added ! Start by importing a Slack team.</li>
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
					<a href="/me/service/create/slack" class="btn btn-primary">Import a Slack team</a>
                </li>

             </ul>
		</div>
		
	</div>
@endsection