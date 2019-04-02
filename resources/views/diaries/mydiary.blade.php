@extends ('dashboard.main')
@section ('title', 'My Diary')

@section ('content')
<div class="container diaries">
	<div class="row m-t-10">
		<div class="col-sm-12">
			<a href="{{ route('dashboard.diaries.index') }}" class="btn btn-outline-secondary"><i class="fas fa-chevron-left"></i> Back to Dashboard</a>
		</div>
	</div>
	<div class="row m-t-10">
		<div class="col-md-9 float-left">
			<h1>My Diaries</h1>
		</div>
		<div class="col-md-3 float-left">
			<a href=" {{ route('diaries.create') }}" class="btn btn-md btn-block btn-primary m-t-10">Create Diary</a>
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
					<div class="col-md-12">
					@if ($diary->days != '0')
					<a href="{{ route('diaries.single', $diary->id) }}" style="text-decoration-line: none;">
					@elseif ($diary->days == '0')
					<a href="{{ route('diaries.tripdiary', [$diary->rental_id, $diary->rental->user_id]) }}" style="text-decoration-line: none;">
					@endif
					@if ($diary->publish == '3')
					<span class="text-danger m-t-20"><i class="fa fa-trash"></i> in trash</span>
					@elseif ($diary->publish == '2')
					<span class="text-success m-t-20"><i class="fas fa-eye"></i> subscriber only</span>
					@elseif ($diary->publish == '1')
					<span class="text-primary m-t-20"><i class="fas fa-eye"></i> published</span>
					@elseif ($diary->publish == '0')
					<span class="text-danger m-t-20"><i class="fas fa-eye-slash"></i> private</span>
					@endif
					<span style="font-size: 20px;"><b> {{ $diary->title }} </b></span>
					@if ($diary->days == '0') <span>({{ $diary->rental->house->house_title }} - {{ date('jS F, Y', strtotime($diary->rental->rental_datein)) }} <i class="fas fa-long-arrow-alt-right"></i> {{ date('jS F, Y', strtotime($diary->rental->rental_dateout)) }})</span>
					@endif
					</a>
					</div>
				</div>
				<div class="card-body" style="padding-top: 0px;">
					<p style="color: #7e7e7e; font-size: 14px; letter-spacing: .04em;">Date modified {{ date('jS F, Y - g:iA', strtotime($diary->updated_at)) }}
					@if ($diary->days != '0')
					<a href="{{ route('diaries.edit', $diary->id) }}" class="btn btn-outline-warning btn-sm btn-block m-t-10" style="max-width: 100px;"><i class="far fa-edit"></i> Edit</a>
					<a href="{{ route('diaries.single', $diary->id) }}" ><div class="text-over-flow-ellipsis"> {!! $diary->message !!} </div></a>
					@elseif ($diary->days == '0')
					<a href="{{ route('diaries.tripdiary', [$diary->rental_id, $diary->rental->user_id]) }}" ><div class="text-over-flow-ellipsis"> {!! $diary->message !!} </div></a>
					@endif</p>
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
