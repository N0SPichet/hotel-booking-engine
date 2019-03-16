@extends ('main')
@section ('title', 'Booking Preview')
@section('stylesheets')
{{ Html::style('css/parsley.css') }}
@endsection

@section ('content')
<div class="container">
	<div class="row m-t-10">
		<div class="col-md-12">
			<h1>Booking Preview <small>(Room : {{ $house->house_title }})</small></h1>
		</div>
	</div>
	<div class="row m-t-10">
		<div class="col-md-12">
			<div class="margin-content">
				<h4>Room details</h4>
				<p>Room name <i class="fa fa-home" aria-hidden="true"></i> <b>{{ $house->house_title }}</b></p>
				<p>Hosted by <i class="fa fa-user" aria-hidden="true"></i> <b>{{ $house->user->user_fname }}</b></p>
				<p>Address <i class="fa fa-map-marker" aria-hidden="true"></i> <b>{{ $house->district->name }}, {{ $house->province->name }}</b></p>
				<p></p>
				<p>Rules : <i class="fa fa-flag-checkered" aria-hidden="true"></i> @foreach ($house->houserules as $key => $rule)<span>{{ $rule->name }}</span>@if (count($house->houserules) != $key+1), @endif @endforeach</p>
				<h4>Booking Details</h4>
				<p>Stay : <i class="fa fa-calendar-check" aria-hidden="true"></i><b> {{ date('jS F, Y', strtotime($datein)) }} <i class="fas fa-long-arrow-alt-right"></i> {{ date('jS F, Y', strtotime($dateout)) }} (<span class="text-success">{{ Carbon::parse($datein)->diffInDays(Carbon::parse($dateout)) }} {{ Carbon::parse($datein)->diffInDays(Carbon::parse($dateout))>'1'?'days':'day' }}</span>)</b></p>
				<form method="POST" action="{{ route('rentals.store') }}" accept-charset="UTF-8">
					{{csrf_field()}}
				{{ Form::hidden('house_id', $house_id, []) }}
				{{ Form::hidden('datein', $datein, []) }}
				{{ Form::hidden('dateout', $dateout, []) }}
				{{ Form::hidden('types', $types, []) }}
				@if ($types == 'room')
				<p>Guest <i class="fa fa-user" aria-hidden="true"></i> <b>{{ $guest }} {{ $guest>1? 'peoples':'people' }}/room</b></p>
				<p>Price <i class="fa fa-credit-card" aria-hidden="true"></i> <b>{{ $house->houseprices->price }} </b>Thai baht/room/night (<b>{{ $no_rooms }} {{ $no_rooms>1?'rooms':'room' }}</b>)</p>
				<p>Food service <i class="fas fa-utensils"></i> <b>{{ $food==1?'yes':'no' }}</b></p>
				{{ Form::hidden('guest', $guest, []) }}
				{{ Form::hidden('no_rooms', $no_rooms, []) }}
				{{ Form::hidden('food', $food, []) }}
				@else
				@if ($no_type_single != '0')<p>Room type : <b> Room Single {{ $no_type_single }} {{ $no_type_single>1?'rooms':'room' }} </b>, Price <b>{{ $type_single_price }} </b>Thai baht/room/night </p>@endif
				@if ($no_type_deluxe_single != '0')<p>Room type : <b> Room Deluxe Single {{ $no_type_deluxe_single }} {{ $no_type_deluxe_single>1?'rooms':'room' }} </b>, Price <b>{{ $type_deluxe_single_price }} </b>Thai baht/room/night </p>@endif
				@if ($no_type_double_room != '0')<p>Room type : <b> Room Double {{ $no_type_double_room }} {{ $no_type_double_room>1?'rooms':'room' }} </b>, Price <b>{{ $type_double_room_price }} </b>Thai baht/room/night </p>@endif
				{{ Form::hidden('no_type_single', $no_type_single, []) }}
				{{ Form::hidden('no_type_deluxe_single', $no_type_deluxe_single, []) }}
				{{ Form::hidden('no_type_double_room', $no_type_double_room, []) }}
				{{ Form::hidden('type_single_price', $type_single_price, []) }}
				{{ Form::hidden('type_deluxe_single_price', $type_deluxe_single_price, []) }}
				{{ Form::hidden('type_double_room_price', $type_double_room_price, []) }}
				@endif
				<button type="submit" class="btn btn-danger">Booking</button>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection
@section('scripts')
{!! Html::script('js/parsley.min.js') !!}
<script type="text/javascript">
	$(document).ready(function() {
		
	});
</script>
@endsection
