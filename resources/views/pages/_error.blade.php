@extends('main')

@section('title','Error')

@section('content')

<div class="container">
	<div class="row">
		<div class="panel panel-default">
			<div class="panel-heading"><h4>Error</h4></div>

			<div class="panel-body">
				<p> {{ $error_m }}</p>
			</div>
		</div>
		
	</div>
</div>
@endsection