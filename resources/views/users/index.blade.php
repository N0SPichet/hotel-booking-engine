@extends ('manages.main')
@section ('title', 'Administrator | Users')
@section ('content')
<div class="container">
	<div class="row m-t-10">
		<div class="col-12">
			<div class="card-title"><h1 class="title-page">Users</h1></div>

			<div class="card-text">
				@foreach ($users as $user)
				<div class="card m-t-10">
					<div class="margin-content">
						<div class="col-md-9 float-left">
							<a href="{{ route('users.show', $user->id) }}" style="text-decoration-line: none; ">
							<p><b>Role</b> <span class="text-danger">{{ $user->hasRole('Admin') ? 'Admin' : 'User' }}</span></p>
							<p>{{ $user->user_fname }} {{ $user->user_lname }} | {{ $user->email }}</p>
							</a>
						</div>

						<div class="col-md-3 float-left" align="center">
							{!! Html::linkRoute('users.show', 'View User Profile', array($user->id), array('class' => 'btn btn-info btn-sm', 'style' => 'width: 60%')) !!}
							{!! Form::open(['route' => ['users.block', $user->id]]) !!}
							{!! Form::submit('Report this User', ['class' => 'btn btn-danger btn-sm m-t-20', 'style' => 'width: 60%']) !!}
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