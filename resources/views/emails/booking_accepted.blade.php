<div style="font-size: 16px;">
	<div align="left" style="background-color: powderblue;">
		<div style="padding: 20px;">
			<p>{{ $bodyMessage }}</p>
			<p>{{ $detailmessage }}</p>
			<p>{{ $endmessage }}</p>
			<a href="{{ route('rentals.show', $rental->id) }}"></a>
			<a href="{{ route('rentals.mytrips', $rental->user_id) }}" style="text-decoration-line: none;">My Trips</a>
		</div>
	</div>
	<div align="center">
		<p>Sent via <b>Love to Travel</b></p>
	</div>
</div>
