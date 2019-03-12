<div style="font-size: 16px;">
	<div>
		<div style="padding: 20px;">
			<p>{{ $bodyMessage }}</p>
			<p>{{ $detailmessage }}</p>
			<ul>
				<li>Title : {{ $house->house_title }}</li>
				<li>Address : {{ $house->address }}{{ $house->sub_district->name }} {{ $house->district->name }}, {{ $house->province->name }}</li>
				<li>Type : {{ ($house->checkType($house->id)? 'Room':'Apartment') }}</li>
				@if($house->checkType($house->id))
				<li>Price : {{ $house->houseprices->price }} Thai baht/room/night</li>
				@else
				<li>
					@if ($house->apartmentprices->type_single)
					<p>Single Room (Standard) : {{ $house->apartmentprices->type_single }} {{ $house->apartmentprices->type_single > 1 ? 'rooms':'room' }} <span>({{ $house->apartmentprices->single_price }} Thai baht/room/night)</span>.</p>
					@endif
					@if ($house->apartmentprices->type_deluxe_single)
					<p>Deluxe Single Room : {{ $house->apartmentprices->type_deluxe_single }} {{ $house->apartmentprices->type_deluxe_single > 1 ? 'rooms':'room' }} <span>({{ $house->apartmentprices->deluxe_single_price }} Thai baht/room/night)</span>.</p>
					@endif
					@if ($house->apartmentprices->type_double_room)
					<p>Double Room (Standard) : {{ $house->apartmentprices->type_double_room }} {{ $house->apartmentprices->type_double_room > 1 ? 'rooms':'room' }} <span>({{ $house->apartmentprices->double_price }} Thai baht/room/night)</span>.</p>
				</li>
				@endif
				@endif
			</ul>
			<p>{{ $endmessage }}
				<br>
				@if($house->checkType($house->id))
				for any details <a href='{{route('rooms.owner', $house->id)}}'>Click Owner</a>
				@else
				for any details <a href='{{route('apartments.owner', $house->id)}}'>Click Owner</a>
				@endif
			</p>
		</div>
	</div>
	<div align="center">
		<p>Sent via <b>Love to Travel</b></p>
	</div>
</div>
