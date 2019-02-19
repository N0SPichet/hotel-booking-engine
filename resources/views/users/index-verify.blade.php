@extends ('main')

@section ('title', 'Administrator | Verify Users')

@section ('content')

<div class="container">
	<div class="row">
		<div class="panel panel-default col">
			<div class="panel-heading"><h1 class="title-page">Unverify Users</h1></div>

			<div class="panel-body">
				@if ($users != NULL)
				@foreach ($users as $user)
				<div class="card margin-top-10">
					<div class="margin-content">
						<div class="col-md-9">
							<a href="{{ route('users.verify-show', $user->id) }}"><p>{{ $user->user_fname }} - {{ $user->email}}</p></a>
						</div>
						<div class="col-md-3" align="center">
							<a href="{{ route('users.verify-show', $user->id) }}" class="btn btn-primary btn-sm" style="width: 60%">View Detail</a>
							{!! Form::open(['route' => ['users.verify-reject', $user->id]]) !!}
								<button type="submit" class="btn btn-danger btn-sm margin-top-10" style="width: 60%"><i class="far fa-times-circle"></i> Reject</button>
							{!! Form::close() !!}
						</div>
					</div>
				</div>
				@endforeach
				@endif
			</div>
		</div>
	</div>
</div>

@endsection