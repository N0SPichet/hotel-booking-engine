@extends('manages.main')
@section('title', 'Manages')
@section('content')
<div class="container">
	<div class="row m-t-10">
		<div class="col-md-12 card">
			<div class="card-title">
				<h4>Diaries</h4>
				@foreach($diaries as $key => $diary)
				<div class="margin-content">
					<p>{{ $diary->title }}</p>
				</div>
				@endforeach
			</div>
		</div>
	</div>
	<div class="row m-t-10">
		<div class="col-md-12 card">
			<div class="card-title">
				<h4>Apartments</h4>
				@foreach($apartments as $key => $apartment)
				<div class="margin-content">
					<p>{{ $apartment->house_title }} <small>rented {{ $apartment->rentals->count() }}</small></p>
				</div>
				@endforeach
			</div>
		</div>
	</div>
	<div class="row m-t-10">
		<div class="col-md-12 card">
			<div class="card-title">
				<h4>Rooms</h4>
				@foreach($rooms as $key => $room)
				<div class="margin-content">
					<p>{{ $room->house_title }} <small>rented {{ $room->rentals->count() }}</small></p>
				</div>
				@endforeach
			</div>
		</div>
	</div>
	<div class="row m-t-10">
		<div class="col-md-12 card">
			<div class="card-title">
				<h4>Components</h4>
			</div>
		</div>
	</div>
</div>
@endsection