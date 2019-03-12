<div style="font-size: 16px;">
	<div align="left">
		<div style="padding: 20px;">
			<p>Dear {{$rental->user->user_fname}} {{$rental->user->user_lname}} <span> you booking was complete</span></p>
			<p>{{$rental->house->district->name}} {{$rental->house->province->name}}</p>
			<p>House name : {{$rental->house->house_title}}</p>
			<p>Stay date : {{date('jS F, Y', strtotime($rental->rental_datein))}} to {{date('jS F, Y', strtotime($rental->rental_dateout))}}</p>
			<p>{{ $endmessage }}</p>
			<a href="{{ route('rentals.mytrips', $rental->user_id) }}" style="text-decoration-line: none;">My Trips</a>
		</div>
	</div>
	<div align="center">
		<p>Sent via <b>Love to Travel</b></p>
	</div>
</div>
