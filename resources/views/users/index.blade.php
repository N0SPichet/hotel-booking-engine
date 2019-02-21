@extends ('main')

@section ('title', 'Administrator | Users')

@section ('content')

<div class="container">
	<div class="row">
		<div class="panel panel-default col">
			<div class="panel-heading"><h1 class="title-page">Users</h1></div>

			<div class="panel-body">
				@foreach ($users as $user)
				<div class="card m-t-10">
					<div class="margin-content">
						<div class="col-md-9">
							<a href="{{ route('users.show', $user->id) }}" style="text-decoration-line: none; ">
							<p><b>Level</b> <span class="text-danger">{{ $user->hasRole('Admin') ? 'Admin' : 'User' }}</span></p>
							<p>{{ $user->user_fname }} {{ $user->user_lname }}</p>
							<p><b>Email</b> {{ $user->email }}</p>
							</a>
						</div>

						<div class="col-md-3" align="center">
							{!! Html::linkRoute('users.show', 'View User Profile', array($user->id), array('class' => 'btn btn-info btn-sm', 'style' => 'width: 60%')) !!}
							{!! Form::open(['route' => ['users.block', $user->id]]) !!}
							{!! Form::submit('Report this User', ['class' => 'btn btn-danger btn-sm btn-h1-spacing', 'style' => 'width: 60%']) !!}
							{!! Form::close() !!}
						</div>
					</div>
				</div>
				@endforeach
			</div>
		</div>
	</div>
</div>

@endsection