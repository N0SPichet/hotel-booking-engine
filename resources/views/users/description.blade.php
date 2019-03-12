@extends('main')
@section('title','About' . ' ' . $user->user_fname)

@section('content')
<div class="container">
	<div class="row m-t-10">
		<div class="card col">
			<div class="card-title"><h4>About {{ $user->user_fname }}</h4></div>
			<div class="card-body">
				<p>{!! $user->user_description !!}</p>
			</div>
		</div>
	</div>
</div>
@endsection
