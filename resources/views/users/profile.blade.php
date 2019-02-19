@extends ('main')

@section ('title', $user->user_fname . ' ' . 'Profile')

@section ('content')
<div class="container">
	<div class="row">
		<div class="panel panel-default col">
			<div class="panel-heading">
				<h1>{{ $user->user_fname }} Account <small>Role:{{$user->roles[0]->name}}</small> @if ($user->verification->verify === '1') <small style="color: green;"><i class="far fa-check-circle"></i>verifired</small> @endif</h1>
				@if ($user->verification->verify !== '1')
				<p class="text-danger"><a href="{{ route('users.verify-user', $user->id) }}" class="btn btn-outline-danger">Verify</a> before become hosting or rent a room.</p>
				@endif
			</div>
			<div class="panel-body">
				<div class="col-md-8 col-sm-8">
					<dl class="dl-horizontal">
						<dt>Name</dt>
						<dd>
							{{ $user->user_fname }} {{ $user->user_lname }}
						</dd>
						<hr>

						@if ($user->user_tel !== null)
						<dt>Phone Number</dt>
						<dd>
							{{ $user->user_tel }}
						</dd>
						<hr>
						@endif

						@if ($user->user_gender !== null)
						<dt>Gender</dt>
						<dd id="gender">{{ $user->user_gender }}</dd>
						<hr>
						@endif

						@if($user->user_address !== null || $user->user_city !== null || $user->user_state !== null || $user->user_country !== null)
						<dt>Address</dt>
						<dd>
							<p>
							@if ($user->user_address !== null) {{ $user->user_address }} @endif
							@if ($user->user_city !== null) {{ $user->user_city }} @endif
							@if ($user->user_state !== null) {{ $user->user_state }}, @endif
							@if ($user->user_country !== null) {{ $user->user_country }} @endif</p>
						</dd>
						<hr>
						@endif

						@if ($user->user_description !== null)
						<dt>Description</dt>
						<dd>
							{!! $user->user_description !!}
						</dd>
						@endif
					</dl>
				</div>

				<div class="col-md-4 col-sm-4" align="center">
					@if ($user->user_image == null)
					<img src="{{ asset('images/users/blank-profile-picture.png') }}" class="rounded-circle" style="width:150px; height: 150px; ">
					@else
					<img src="{{ asset('images/users/'. $user->id . '/' . $user->user_image) }}" class="rounded-circle" style="width:150px; height: 150px;">
					@endif

					{!! Form::open(['route' => ['users.updateimage', $user->id], 'files' => true]) !!}
						{{ Form::label('user_image', 'Profile Photo', array('class' => 'form-spacing-top-8 text-center')) }}
							
						<div class="fileupload fileupload-new text-center" data-provides="fileupload">
						    <span class="btn btn-primary btn-file">
						    	<span class="fileupload-new">Select file</span>
						    	<span class="fileupload-exists">Change</span>
						    	<input name="user_image" type="file" id="user_image">
						    </span>
						    <span class="fileupload-preview"></span>
						    <a href="#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none">×</a>
						</div>

						<div style="width: 50%;">
							{{ Form::submit('Update image', ['class' => 'btn btn-success btn-block']) }}
						</div>
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
	
	<div class="card">
		<div class="margin-content">
			<div class="col-md-3 col-sm-3">
				{!! Html::linkRoute('users.edit', 'Update Account', array($user->id), array('class' => 'btn btn-info btn-block')) !!}
			</div>

			<div class="col-md-3 col-sm-3">
				{!! Html::linkRoute('mytrips', 'My Trips', array($user->id), array('class' => 'btn btn-info btn-block')) !!}
			</div>

			<div class="col-md-3 col-sm-3">
				{!! Html::linkRoute('diaries.mydiaries', 'My Diaries', array($user->id), array('class' => 'btn btn-info btn-block')) !!}
			</div>

			<div class="col-md-3 col-sm-3">
				{!! Html::linkRoute('users.description', 'About My Self', array($user->id), array('class' => 'btn btn-info btn-block')) !!}
			</div>
		</div>
	</div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
	$( document ).ready(function() {
		if($('#gender').text() === '1')
		{
			$('#gender').text('Male')
		}
		else
		{
			$('#gender').text('Female')
		}
	});
</script>
@endsection
