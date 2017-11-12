@extends ('main')

@section ('title', 'Profile | All Users')

@section ('content')
<div class="container">
	<div class="row">
		<div class="col-md-12 col-md-offset-0">
			<div class="col-md-8">
				<p class="lead">{{ $user->user_fname }} Account</p>
					<dl class="dl-horizontal">
						<dt>First Name</dt>
						<dd>
							{{ $user->user_fname }}
						</dd>

						<dt>Last Name</dt>
						<dd>
							{{ $user->user_lname }}
						</dd>

						<dt>Phone Number</dt>
						<dd>
							{{ $user->user_tel }}
						</dd>

						<dt>Gender</dt>
						<dd>
							{{ $user->user_gender }}
						</dd>
						<dt>Address</dt>
						<dd>
							{{ $user->user_address }}
						</dd>

						<dt>City</dt>
						<dd>
							{{ $user->user_city }}
						</dd>

						<dt>State / Province</dt>
						<dd>
							{{ $user->user_state }}
						</dd>

						<dt>Country</dt>
						<dd>
							{{ $user->user_country }}
						</dd>

						<dt><a href="{{ route('users.description', $user->id) }}" class="btn">Description</a></dt>
						<dd>
							{{ $user->user_description }}
						</dd>

						<dt>Rating</dt>
						<dd>
							{{ $user->user_score }}
						</dd>
					</dl>
			</div>

			<div class="col-md-4">
				<p class="lead">Hosting List</p>
				@foreach ($houses as $house)
					<a href="{{ route('rooms.single', $house->id) }}">
						<p>#ID : {{ $house->id }}</p>
					</a>
					<p>Title : {{ $house->house_title }}</p>
					<p>Last update : {{ date("jS F, Y", strtotime($house->updated_at)) }}</p>
					<br>
				@endforeach
			</div>
		</div>
	</div> <!-- end of header row-->

	<div class="row">
			<div class="col-sm-6">
				{!! Html::linkRoute('users.index', 'Back to All Users', array(''), array('class' => 'btn btn btn-link btn-md')) !!}
			</div>
		</div>
</div>
@endsection