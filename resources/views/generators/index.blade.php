@extends('layouts.app')
 
@section('content')

	<div class="row">
		<div class="col-md-12">
			<h3>Generators</h3>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<p>Start by configuring services to enable you to connect with slack channels.</p>
			<div class="panel panel-default">

				<div class="panel-heading">My generators</div>

				@if(count($generators) == 0)
					<div class="panel-body">
						<p>No service added ! Start by adding a slack service and a google analytics service.</p>
					</div>
				@endif
				
				@if(count($generators) > 0)
					@foreach($generators as $generator)
						<li class="list-group-item">
							<div class="row">
								<div class="col-md-8">
									<h5>{{ $generator['template'] }}</h5>
								</div>
								<div class="col-md-4">
									<a href="me/generator/{{ $generator['id'] }}/preview" class="btn btn-default pull-right">Preview</a>
									<a href="me/generator/{{ $generator['id'] }}/preview" class="btn btn-default pull-right">Edit</a>
									<a href="me/generator/{{ $generator['id'] }}/preview" class="btn btn-default pull-right">Delete</a>
								</div>
							</div>
						</li>
					@endforeach
				@endif

			</div>
		</div>
	</div>
@endsection