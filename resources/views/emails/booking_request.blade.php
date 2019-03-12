<div style="font-size: 16px;">
	<div align="left" style="background-color: powderblue;">
		<div style="padding: 20px;">
			<p>Dear {{$rental->house->user->user_fname}} {{$rental->house->user->user_lname}}</p>
			<p>{{ $bodyMessage }}</p>
			<p>you have new request for booking your room "{{$rental->house->house_title}}" from <a href="{{route('users.show', $rental->user_id)}}">{{$rental->user->user_fname}}</a>.</p>
			<p>Stay date : {{date('jS F, Y', strtotime($rental->rental_datein))}} to {{date('jS F, Y', strtotime($rental->rental_dateout))}}</p>
			<p>{{ $endmessage }}</p>
			<a href="{{ route('rentals.rentmyrooms', $rental->house->user_id) }}">Manage</a>
		</div>
	</div>
	<div align="center">
		<p>Sent via <b>Love to Travel</b></p>
	</div>
</div>
