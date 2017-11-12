@extends ('main')

@section ('title', $diary->users->user_fname. ' | ' .'All Diary')

@section ('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<a href="{{ URL::previous() }}" class="btn btn-default btn-lg"><span class="glyphicon glyphicon-chevron-left"></span>Back to Diaries</a>
		</div>
		<div class="col-md-12">
			<h2>{{ $diary->title }}</h2>
			<p> {{ $diary->message }}</p>
			<hr>
			<div class="tags">
				@foreach ($diary->tags as $tag)
					<span class="label label-default">{{ $tag->tag_name }}</span>
				@endforeach
			</div>
			<hr>
			<p>Public by : {{ $diary->users->user_fname }}</p>
			<p>Publish date : {{ date('jS F, Y', strtotime($diary->created_at)) }}</p>
		</div>
	</div>
</div>
@endsection