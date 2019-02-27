<div style="font-size: 16px;">
	<div align="left" style="background-color: powderblue;">
		<div style="padding: 20px;">
			<p>{{ $bodyMessage }}</p>
			<p>{{ $detailmessage }}</p>
			<p>{{ $guest }} guest.</p>
			<p>{{ $endmessage }}</p>
			<a href="{{ route('rentals.mytrips', $rentlUserId) }}" style="text-decoration-line: none;">My Trips</a>
		</div>
	</div>
	<div align="center">
		<p>Sent via <b>Love to Travel</b></p>
	</div>
</div>