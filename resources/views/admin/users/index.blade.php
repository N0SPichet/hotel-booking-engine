@extends ('admin.layouts.app')
@section ('title', 'Users')

@section ('content')
<div class="container">
	<div class="row m-t-10">
		<div class="col-sm-12">
			<a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary"><i class="fas fa-chevron-left"></i> Back to Dashboard</a>
		</div>
	</div>
	<div class="row m-t-10">
		<div class="col-12">
			<div class="card-title"><h1 class="title-page">Users</h1></div>

			<div class="card-text">
				@foreach ($users as $user)
				<div class="card m-t-10">
					<div class="margin-content">
						<div class="col-md-9 float-left">
							<a href="{{ route('admin.users.show', $user->id) }}" style="text-decoration-line: none; ">
							<p><b>Role</b> <span class="text-danger">{{ $user->hasRole('Admin') ? 'Admin' : 'User' }}</span></p>
							<p>{{ $user->user_fname }} {{ $user->user_lname }} | {{ $user->email }}</p>
							</a>
						</div>

						<div class="col-md-3 float-left" align="center">
							{!! Html::linkRoute('admin.users.show', 'View User Profile', array($user->id), array('class' => 'btn btn-info btn-sm', 'style' => 'width: 150px;')) !!}
							{!! Form::open(['route' => ['admin.users.block', $user->id]]) !!}
							{!! Form::submit('Report this User', ['class' => 'btn btn-danger btn-sm m-t-20', 'style' => 'width: 150px;']) !!}
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
