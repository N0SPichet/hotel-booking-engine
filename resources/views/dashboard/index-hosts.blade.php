@extends('dashboard.main')
@section('title', 'Dashboard | Hosting')

@section('content')
<div class="container dashboard-index">
	<div class="col-md-3 float-left m-t-10">
		@include('layouts.side-tab-dashboard')
	</div>
	<div class="col-md-9 float-left m-t-10">
		<div class="card-body">
			<div class="card-title">
				<h4>{{ Auth::user()->user_fname }}'s Rooms</h4>
			</div>
			<div class="card-text">
				<div class="row m-t-10">
					<div class="col-md-12 card">
						<div class="card-title">
							<h4>Rooms <small>({{$rooms->count()}} of {{$rooms_total}} {{$rooms_total>1?'rooms':'room'}})</small></h4>
							@foreach ($rooms as $key=>$room)
							<div class="margin-content text-title">
								@if ($room->checkType($room->id))
								<p class="text-title"><a href="{{route('rooms.owner', $room->id)}}">
									@if ($room->publish == '2')
									<span class="text-danger"><i class="fas fa-trash"></i> trash</span>
									@elseif ($room->publish == '1')
									<span class="text-success"><i class="fas fa-eye"></i> published</span>
									@elseif ($room->publish == '0')
									<span class="text-danger"><i class="fas fa-eye-slash"></i> private</span>
									@endif{{ $room->house_title }} - {{ $room->sub_district->name }} {{ $room->district->name }}, {{ $room->province->name }}
								</a></p>
								@endif
							</div>
							@endforeach
						</div>
						<div class="margin-content">
							<div class="m-t-10 text-center">
								<a href="{{ route('hosts.introroom') }}" class="btn btn-danger">New Room</a>
								<a href="{{ route('rooms.index') }}" class="btn btn-info">Lists Rooms</a>
							</div>
						</div>
					</div>
					<div class="col-md-12 m-t-10 card">
						<div class="card-title">
							<h4>Apartments <small>({{$apartments->count()}} of {{$apartments_total}} {{$apartments_total>1?'rooms':'room'}})</small></h4>
							@foreach ($apartments as $key=>$room)
							<div class="margin-content text-title">
								@if (!$room->checkType($room->id))
								<p class="text-title"><a href="{{route('apartments.owner', $room->id)}}">
									@if ($room->publish == '2')
									<span class="text-danger"><i class="fas fa-trash"></i> trash</span>
									@elseif ($room->publish == '1')
									<span class="text-success"><i class="fas fa-eye"></i> published</span>
									@elseif ($room->publish == '0')
									<span class="text-danger"><i class="fas fa-eye-slash"></i> private</span>
									@endif{{ $room->house_title }} - {{ $room->sub_district->name }} {{ $room->district->name }}, {{ $room->province->name }}
								</a></p>
								@endif
							</div>
							@endforeach
						</div>
						<div class="margin-content">
							<div class="m-t-10 text-center">
								<a href="{{ route('hosts.introapartment') }}" class="btn btn-danger m-t-10">New Apartment</a>
								<a href="{{ route('apartments.index') }}" class="btn btn-info m-t-10">Lists Apartments</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
