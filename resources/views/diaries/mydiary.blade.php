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
	<div class="row" align="center">
		<div class="margin-auto">
			{!! $diaries->links() !!}
		</div>
	</div>
	<div class="row mydiaries">
		<div class="col">
			@if($diaries->count() > 0)
			@foreach($diaries as $diary)
			@if (Auth::user()->id == $diary->user_id)
			<div class="card col m-t-10">
				<div class="card-title">
					<div class="col-md-10 float-left">
					@if ($diary->days != '0')
					<a href="{{ route('diaries.single', $diary->id) }}" style="text-decoration-line: none;">
					@elseif ($diary->days == '0')
					<a href="{{ route('diaries.tripdiary', [$diary->rental_id, $diary->rental->user_id]) }}" style="text-decoration-line: none;">
					@endif
					@if ($diary->publish == '2')
					<span class="text-success m-t-20"><i class="fas fa-eye"></i> Published</span>
					@elseif ($diary->publish == '1')
					<span class="text-primary m-t-20"><i class="fas fa-eye"></i> Follower</span>
					@elseif ($diary->publish == '0')
					<span class="text-danger m-t-20"><i class="fas fa-eye-slash"></i> Private</span>
					@endif
					<span style="font-size: 20px;"><b> {{ $diary->title }} </b></span>
					@if ($diary->days == '0') <span>({{ $diary->rental->houses->house_title }} - {{ date('jS F, Y', strtotime($diary->rental->rental_datein)) }} <i class="fas fa-long-arrow-alt-right"></i> {{ date('jS F, Y', strtotime($diary->rental->rental_dateout)) }})</span>
					@endif
					</a>
					</div>
					<div class="col-md-2 float-left">
						<div class="margin-auto" align="center">
					@if ($diary->days != '0')
					<a href="{{ route('diaries.single', $diary->id) }}" class="btn btn-primary btn-sm m-t-10">Read More</a>
					<a href="{{ route('diaries.edit', $diary->id) }}" class="btn btn-outline-warning btn-sm m-t-10"><i class="far fa-edit"></i> Edit</a>
					@elseif ($diary->days == '0')
					<a href="{{ route('diaries.tripdiary', [$diary->rental_id, $diary->rental->user_id]) }}" class="btn btn-primary btn-sm">Read More</a>
					@endif
						</div>
					</div>
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
		</div>
	</div>
	<div class="row" align="center">
		<div class="margin-auto">
			{!! $diaries->links() !!}
		</div>
	</div>
</div>
@endsection
