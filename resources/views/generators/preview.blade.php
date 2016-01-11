@extends('layouts.app')
 
@section('content_header')
	<div class="row">
		<div class="col-md-12">
			<h4>Generator preview</h4>
		</div>
	</div>
@endsection

@section('content')

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="col-md-12">
						<p>If your report was published now, here is what it would look like :</p>
						<blockquote>{!! $message !!}</blockquote>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection