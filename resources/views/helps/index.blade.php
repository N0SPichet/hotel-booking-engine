@extends('main')

@section('title','Helps')

@section('content')

<div class="container">
	<div class="row">
		<div class="panel panel-default col">
			<div class="panel-heading">
				<h1 class="title-page">Helps</h1>
			</div>
			<div class="panel-body">
				<a href="{{ route('aboutus') }}" class="btn btn-primary btn-md pull-right" style="margin-top: 5px; margin-left: 5px;">About Us</a>
				<a href="{{ route('getcontact') }}" class="btn btn-primary btn-md pull-right" style="margin-top: 5px; margin-left: 5px;">Contact Us</a>
				<a href="{{ route('checkincode') }}" class="btn btn-outline-info">	Check in Code</a>
				<a href="{{ route('maps.index') }}" class="btn btn-outline-info">		Maps</a>
			</div>
		</div>
		
	</div>
</div>
@endsection