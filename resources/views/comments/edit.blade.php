@extends ('main')

@section ('title', 'Edit comment')

@section ('content')

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h1>Edit Comment</h1>
			{!! Form::model($comment, ['route' => ['comments.update', $comment->id], 'method' => 'PUT']) !!}
				{{ Form::label('name', 'Name') }}
				{{ Form::text('name', null, ['class' => 'form-control', 'disabled' => 'disabled']) }}

				{{ Form::label('email', 'Email') }}
				{{ Form::text('email', null, ['class' => 'form-control', 'disabled' => 'desabled']) }}

				{{ Form::label('comment', 'Comment:') }}
				{{ Form::textarea('comment', null, ['class' => 'form-control', 'rows' => '5']) }}
				<div class="text-center">
					{{ Form::submit('Update comment', ['class' => 'btn btn-success form-spacing-top-8']) }}
				</div>
			{!! Form::close() !!}
		</div>
	</div>
</div>

@endsection