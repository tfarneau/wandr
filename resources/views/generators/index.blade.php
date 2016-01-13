@extends('layouts.app')

@section('content')

	<div class="row">

		<div class="col-md-12">
			<p class="lead">My generators</p>
			<ul class="list-group">
                @if(count($generators) == 0)
					<li class="list-group-item">No generator added !</li>
				@endif

				@if(count($generators) > 0)
					@foreach($generators as $generator)
						<li class="list-group-item">

							<div>
								{{ $generator['name'] }}
								
								@if($generator['is_active'] == 1)
									<span class="label label-info active-status">Active</span>
								@else
									<span class="label label-danger active-status">Unactive</span>
								@endif

								<div class="btn-group pull-right">
									@if($generator['is_active'] == 1)
										<a href="/me/generator/{{ $generator['id'] }}/unactivate" class="btn btn-default">Unactivate</a>
									@else
										<a href="/me/generator/{{ $generator['id'] }}/activate" class="btn btn-default">Activate</a>
									@endif
									<a href="/me/generator/{{ $generator['id'] }}/edit" class="btn btn-default">Edit</a>
									<a href="/me/generator/{{ $generator['id'] }}/test" class="btn btn-default">Test now</a>
								</div>
							</div>

							<div class="times">
								<?php $hours = explode(',',$generator['activation_hours']); ?>
								@foreach($hours as $h)
									<span class="label label-success">{{ $h }}h</span>
								@endforeach

								<?php $days = explode(',',$generator['activation_days']); ?>
								<?php
									$days_array = array(
									    'Monday',
									    'Tuesday',
									    'Wednesday',
									    'Thursday',
									    'Friday',
									    'Saturday',
									    'Sunday'
									);
								?>

								@foreach($days as $d)
									<span class="label label-success">{{ $days_array[$d-1] }}</span>
								@endforeach
							</div>
		                </li>
					@endforeach
				@endif

				<li class="list-group-item">
					<a href="/me/generator/create" class="btn btn-primary">Create a generator</a>
                </li>
             </ul>
		</div>
		
	</div>
@endsection