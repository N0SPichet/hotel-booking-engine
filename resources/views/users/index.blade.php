@extends ('main')

@section ('title', 'Administrator | Users')

@section ('content')

<div class="container">
	<div class="row">
		<div class="panel panel-default">
			<div class="panel-heading"><h1>Users</h1></div>

			<div class="panel-body">
				@foreach($users as $user)
					<div class="row">
						<div class="col-md-12">
							<div class="col-md-4">
								<p> #ID {{ $user->id }}</p>
								<p>Name {{ $user->user_fname }} {{ $user->user_lname }}</p>
								<p>Email {{ $user->email }}</p>
							</div>

							<div class="col-md-4 text-center">
								<p class="">Rating <h3>{{ $user->user_score }}</h3></p>
							</div>

							<div class="col-md-2 col-md-offset-1">
								{!! Html::linkRoute('users.show', 'View User Profile', array($user->id), array('class' => 'btn btn-info btn-sm btn-block')) !!}

								{!! Form::open(['route' => ['users.report', $user->id]]) !!}

								{!! Form::submit('Report this User', ['class' => 'btn btn-danger btn-sm btn-block btn-h1-spacing']) !!}

								{!! Form::close() !!}
							</div>
						</div> <!-- end of col-md-12 -->
					</div>
					<hr>
				@endforeach
			</div>
		</div>
	</div>
</div>

@endsection