@extends ('main')

@section ('title', Auth::user()->user_fname . ' ' . 'Profile')

@section ('content')
<div class="container">
	<div class="row">
		<div class="panel panel-default">
			<div class="panel-heading"><h1>{{ Auth::user()->user_fname }} Account</h1></div>

			<div class="panel-body">
				<div class="col-md-8">
					@foreach($users as $user)
					<dl class="dl-horizontal">
						<dt>Name</dt>
						<dd>
							{{ $user->user_fname }} {{ $user->user_lname }}
						</dd>

						@if ($user->user_tel != NULL)
						<dt>Phone Number</dt>
						<dd>
							{{ $user->user_tel }}
						</dd>
						@endif

						@if ($user->user_gender != NULL)
						<dt>Gender</dt>
						<dd>
							{{ $user->user_gender }}
						</dd>
						@endif

						@if ($user->user_address != NULL)
						<dt>Address</dt>
						<dd>
							{{ $user->user_address }}
						</dd>
						@endif

						@if ($user->user_city != NULL)
						<dt>City</dt>
						<dd>
							{{ $user->user_city }}
						</dd>
						@endif

						@if ($user->user_state != NULL)
						<dt>State / Province</dt>
						<dd>
							{{ $user->user_state }}
						</dd>
						@endif

						@if ($user->user_country != NULL)
						<dt>Country</dt>
						<dd>
							{{ $user->user_country }}
						</dd>
						@endif

						@if ($user->user_description != NULL)
						<dt>Description</dt>
						<dd>
							{{ $user->user_description }}
						</dd>
						@endif
					</dl>
					@endforeach
				</div>

				<div class="col-md-4">
					@if ($user->user_image == null)
						<div class="text-center">
							<img src="{{ asset('images/users/blank-profile-picture.png') }}" style="width:150px; height: 150px; float: left; border-radius: 50%; margin-right: 25px;">
						</div>
					@else
						<div class="text-center" style="position: relative; width: 100px; height: 100px; overflow: hidden; border-radius: 50%;">
							<img src="{{ asset('images/users/' . $user->user_image) }}" style="width: auto; height: 100px;">
						</div>
					@endif

					{!! Form::open(['route' => ['users.updateimage', $user->id], 'files' => true]) !!}
						{{ Form::label('user_image', 'Prifile Photo', array('class' => 'form-spacing-top-8')) }}
						
						<div class="fileupload fileupload-new" data-provides="fileupload">
						    <span class="btn btn-primary btn-file">
						    	<span class="fileupload-new">Select file</span>
						    	<span class="fileupload-exists">Change</span>
						    	<input name="user_image" type="file" id="user_image">
						    </span>
						    <span class="fileupload-preview"></span>
						    <a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none">×</a>
						</div>

						<div class="col-md-6 col-md-offset-3 col-xs-6 col-xs-offset-3">
							{{ Form::submit('Add image', ['class' => 'btn btn-success btn-block btn-h1-spacing']) }}
						</div>



					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div> <!-- end of header row-->

	<div class="row">
		<div class="col-md-12 col-md-offset-0">
			<div class="col-md-3">
				{!! Html::linkRoute('users.edit', 'Update Account', array($user->id), array('class' => 'btn btn-info btn-h1-spacing btn-block')) !!}
			</div> <!-- end of col-md-3 -->

			<div class="col-md-3">
				{!! Html::linkRoute('mytrips', 'My Trips', array($user->id), array('class' => 'btn btn-info btn-h1-spacing btn-block')) !!}
			</div> <!-- end of col-md-3 -->

			<div class="col-md-3">
				{!! Html::linkRoute('diaries.mydiaries', 'My Diaries', array($user->id), array('class' => 'btn btn-info btn-h1-spacing btn-block')) !!}
			</div> <!-- end of col-md-3 -->

			<div class="col-md-3">
				{!! Html::linkRoute('users.description', 'About My Self', array($user->id), array('class' => 'btn btn-info btn-h1-spacing btn-block')) !!}
			</div> <!-- end of col-md-3 -->
		</div>
	</div>
</div>
@endsection