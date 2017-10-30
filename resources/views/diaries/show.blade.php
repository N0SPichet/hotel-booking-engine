@extends ('main')

@section ('title', $diary->users->user_fname. ' | ' .'All Diary')

@section ('content')
<div class="container">
	<div class="row">
			<div class="col-md-12">
				<h1>{{ $diary->title }}</h1>
				<p> {{ $diary->message }}</p>
				<hr>
				<p>Public by : {{ $diary->users->user_fname }}</p>
				<p>Public date : {{ date('jS F, Y', strtotime($diary->created_at)) }}</p>
			</div>
	</div>
	<a href="{{ URL::previous() }}" class="btn btn-default btn-lg"><span class="glyphicon glyphicon-chevron-left"></span></a>
</div>
@endsection