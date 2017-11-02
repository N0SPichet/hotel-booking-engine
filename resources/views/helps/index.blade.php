@extends('main')

@section('title','Helps')

@section('content')

<div class="container">
	<div class="row">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h1>Helps
				<a href="{{ route('getcontact') }}" class="btn btn-primary btn-md pull-right" style="margin-top: 5px;">Contact Us</a></h1>
			</div>
			<div class="panel-body">
				<a href="{{ route('checkincode') }}" class="btn btn-default btn-md">Check in Code</a>
			</div>
		</div>
		
	</div>
</div>
@endsection