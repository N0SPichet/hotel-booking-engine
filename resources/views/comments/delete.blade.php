@extends ('main')

@section ('title', 'Delete comment')

@section ('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h1>Delete this Comment?</h1>
			<p>
				<strong>Name:</strong> {{ $comment->name }}<br>
				<strong>Email:</strong> {{ $comment->email }}<br>
				<strong>comment:</strong> {{ $comment->comment }}
			</p>
			{!! Form::open(['route' => ['comments.destroy', $comment->id], 'method' => 'DELETE']) !!}
				{{ Form::submit('Yes delete this comment', ['class' => 'btn btn-danger btn-block btn-md']) }}
			{!! Form::close() !!}
		</div>
	</div>
</div>
@endsection