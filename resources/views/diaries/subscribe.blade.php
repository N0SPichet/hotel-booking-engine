@extends ('main')
@section ('title', 'Subscribe')

@section ('content')
<div class="container">
	<div class="row m-t-10">
		<div class="col-sm-12">
			<a href="{{ route('diaries.index') }}" class="btn btn-outline-secondary"><i class="fas fa-chevron-left"></i> Explore diaries</a>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12 col-sm-12">
			<div class="col-md-12">
				<h2 class="title-page">Follow <span style="text-transform: lowercase;">{{ $diary->user->user_fname }}</span></h2>
			</div>
			<div class="col-md-10">
				<p style="font-size: 18px;">Only follower can read this diary, if you want to read. you need to follow author (<span style="text-transform: lowercase;">{{ $diary->user->user_fname }}</span>).</p>
			</div>
			<div class="col-md-2">
				{!! Form::open(['route'=> ['diaries.subscribe', $diary->user_id], 'method'=>'GET']) !!}
				{!! Form::hidden('diary_id', $diary->id, []) !!}
				<button class="btn btn-danger m-t-10">Follow {{ $diary->user->user_fname }}</button>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>
@endsection
