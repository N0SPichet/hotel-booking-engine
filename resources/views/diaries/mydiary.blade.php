@extends ('main')

@section ('title', 'My Diary')

@section ('content')
<div class="container diaries">
	<div class="row m-t-10">
		<div class="col-md-10 float-left">
			<h1>My Diaries</h1>
		</div>
		<div class="col-md-2 float-left">
			<a href=" {{ route('diaries.create') }}" class="btn btn-lg btn-block btn-primary btn-h1-spacing">Create Diary</a>
		</div>
		<div class="col-md-12">
			<hr>
		</div>
	</div>

	<div class="row mydiaries">
		<div class="col">
			@if($diaries->count() > 0)
			@foreach($diaries as $diary)
			@if (Auth::user()->id == $diary->users_id)
			<div class="card col">
				<div class="card-title">
					@if ($diary->days != '0')
					<a href="{{ route('diaries.single', $diary->id) }}" style="text-decoration-line: none;">
					@elseif ($diary->days == '0')
					<a href="{{ route('diaries.tripdiary', [$diary->rentals_id, $diary->rentals->user_id]) }}" style="text-decoration-line: none;">
					@endif
					@if ($diary->publish == '2')
					<span class="text-success m-t-20"><i class="fas fa-eye"></i> Published</span>
					@elseif ($diary->publish == '1')
					<span class="text-primary m-t-20"><i class="fas fa-eye"></i> Follower</span>
					@elseif ($diary->publish == '0')
					<span class="text-danger m-t-20"><i class="fas fa-eye-slash"></i> Private</span>
					@endif
					<span style="font-size: 20px;"><b> {{ $diary->title }} </b></span>
					@if ($diary->days == '0') <span>({{ $diary->rentals->houses->house_title }} - {{ date('jS F, Y', strtotime($diary->rentals->rental_datein)) }} <i class="fas fa-long-arrow-alt-right"></i> {{ date('jS F, Y', strtotime($diary->rentals->rental_dateout)) }})</span>
					@endif
					</a>
					@if ($diary->days != '0')
					<a href="{{ route('diaries.single', $diary->id) }}" class="btn btn-primary btn-sm float-right" style="position: relative;">Read More</a>
					<a href="{{ route('diaries.edit', $diary->id) }}" class="btn btn-outline-warning btn-sm p-r-20 m-r-20"><i class="far fa-edit"></i> Edit</a>
					@elseif ($diary->days == '0')
					<a href="{{ route('diaries.tripdiary', [$diary->rentals_id, $diary->rentals->user_id]) }}" class="btn btn-primary btn-sm float-right">Read More</a>
					@endif
				</div>
				<div class="card-body">
					<p style="color: #7e7e7e; font-size: 14px; letter-spacing: .04em;">Date modified {{ date('jS F, Y - g:iA', strtotime($diary->updated_at)) }}</p>
					<div class="text-over-flow-ellipsis"> {!! $diary->message !!} </div>
				</div>
			</div>
			@endif
			@endforeach
			@else
			<div class="text-center m-t-10">
				<p>No result</p>
			</div>
			@endif
			<div class="text-center">
				{!! $diaries->links() !!}
			</div>
		</div>
	</div>
</div>
@endsection
