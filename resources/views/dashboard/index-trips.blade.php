@extends('dashboard.main')
@section('title', 'Dashboard | Trips')

@section('content')
<div class="container dashboard-index">
	<div class="col-md-3 float-left m-t-10">
		@include('layouts.side-tab-dashboard')
	</div>
	<div class="col-md-9 float-left m-t-10">
		<div class="card-body">
			<div class="card-title">
				<h4>{{ Auth::user()->user_fname }}'s Trips</h4>
			</div>
			<div class="card-text">
				<div class="row m-t-10">
					<div class="col-md-12 card">
						<div class="card-title">
							<h4>Trips <small>({{$rentals->count()}} of {{Auth::user()->rentals->count()}} {{Auth::user()->rentals->count()>1?'trips':'trip'}})</small></h4>
							@foreach ($rentals as $key=>$rental)
							<div class="margin-content text-title">
								<a href="{{route('rentals.show', $rental->id)}}">
								@if ($rental->payment->payment_status == 'Approved' && $rental->checkin_status == '0' )
								<p class="text-primary"><b>payment complete.</b></p>
								@elseif ( $rental->payment->payment_status == 'Approved' && $rental->checkin_status == '1' )
								<p class="text-success"><b>checkin confirmed.</b></p>
								@elseif ( $rental->host_decision == 'accept' && $rental->checkin_status == '0' )
								<p class="text-primary"><b>host accepted.</b></p>
								@else
								<p class="text-danger">{{$rental->payment->payment_status!=null?"payment ".$rental->payment->payment_status:"host ".$rental->host_decision}}</p>
								@endif
								<p>@if($rental->house->checkType($rental->house_id)) <img src="{{ asset('images/houses/house.png')}}" style="height: 20px; width: 20px; margin-bottom: 10px;"> @else <img src="{{ asset('images/houses/apartment.png')}}" style="height: 20px; width: 20px; margin-bottom: 10px;"> @endif Room Name :  {{ $rental->house->house_title }}  </p>
								<p><i class="far fa-calendar-alt"></i> Date : {{ date('jS F, Y', strtotime($rental->rental_datein)) }} <i class="fas fa-long-arrow-alt-right"></i> {{ date('jS F, Y', strtotime($rental->rental_dateout)) }} ({{ Carbon::parse($rental->rental_datein)->diffInDays(Carbon::parse($rental->rental_dateout))+1 }} {{ Carbon::parse($rental->rental_datein)->diffInDays(Carbon::parse($rental->rental_dateout))+1>'1'?'days':'day' }}) </p>
								<p><i class="far fa-user"></i> {{ $rental->rental_guest }} guest</p>
								</a>
							</div>
							@if ($rentals->count() != $key+1)<hr>@endif
							@endforeach
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="margin-content">
						<div class="m-t-10 text-center">
							<a href="{{ route('rentals.mytrips', Auth::user()->id) }}" class="btn btn-info">All Trips</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
