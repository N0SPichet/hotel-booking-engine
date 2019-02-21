@extends('main')

@section('title','Helps')

@section('content')

<div class="container">
	<div class="row m-t-10">
		<div class="card col">
			<div class="card-title">
				<h1 class="title-page">Helps</h1>
			</div>
			<div class="card-body">
				<a href="{{ route('aboutus') }}" class="btn btn-primary btn-md pull-right" style="margin-top: 5px; margin-left: 5px;">About Us</a>
				<a href="{{ route('getcontact') }}" class="btn btn-primary btn-md pull-right" style="margin-top: 5px; margin-left: 5px;">Contact Us</a>
				<a href="{{ route('checkincode') }}" class="btn btn-outline-info">	Check in Code</a>
				<a href="{{ route('maps.index') }}" class="btn btn-outline-info">		Maps</a>
			</div>
		</div>
		
	</div>
</div>
@endsection