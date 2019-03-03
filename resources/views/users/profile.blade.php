@extends ('main')

@section ('title', $user->user_fname . ' ' . 'Profile')

@section ('content')
<div class="container">
	<div class="row m-t-10">
		<div class="card col-12">
			<div class="card-body">
				<div class="card-title">
					<h1>{{ $user->user_fname }} Account <small>Role:{{$user->roles[0]->name}}</small> @if ($user->verification->verify === '1') <small style="color: green;"><i class="far fa-check-circle"></i>verifired</small> @endif</h1>
					@if ($user->verification->verify !== '1')
					<p class="text-danger"><a href="{{ route('users.verify-user', $user->id) }}" class="btn btn-outline-danger">Verify</a> before become hosting or rent a room.</p>
					@endif
				</div>
				<div class="card-text">
					@if ($user->verification->passport != null)
					<div class="col-md-12">
						<p>your passport : <b class="text-danger">{{ substr($user->verification->passport, 9, 3) }}{{ substr($user->verification->passport, 15, 3) }}{{ substr($user->verification->passport, 12, 3) }}</b> keep it's secret</p>
						<p>passport code you can use to identify yourself when checkin. please keep it's secret and don't tell anyone or hosts that you has rent their's home.</p>
					</div>
					@endif
					<div class="col-md-8 col-sm-8 float-left">
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

							@if ($user->user_gender != null)
							<dt>Gender</dt>
							<dd id="gender">{{ $user->user_gender }}</dd>
							<hr>
							@endif

							@if($user->user_address !== null || $user->sub_district_id !== null || $user->district_id !== null || $user->province_id !== null)
							<dt>Address</dt>
							<dd>
								<p>
								@if ($user->user_address !== null) {{ $user->user_address }} @endif
								@if ($user->sub_district->name !== null) {{ $user->sub_district->name }} @endif
								@if ($user->district->name !== null) {{ $user->district->name }}, @endif
								@if ($user->province->name !== null) {{ $user->province->name }} @endif</p>
							</dd>
							<hr>
							@endif

							@if ($user->user_description != null)
							<dt>Description</dt>
							<dd>
								{!! $user->user_description !!}
							</dd>
							@endif
						</dl>
					</div>

					<div class="col-md-4 col-sm-4 float-left" align="center">
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
		<div class="card col-12 m-t-10">
			<div class="margin-content">
				<div class="col-md-3 col-sm-3 float-left">
					{!! Html::linkRoute('users.edit', 'Update Account', array($user->id), array('class' => 'btn btn-info btn-block')) !!}
				</div>

				<div class="col-md-3 col-sm-3 float-left">
					{!! Html::linkRoute('rentals.mytrips', 'My Trips', array($user->id), array('class' => 'btn btn-info btn-block')) !!}
				</div>

				<div class="col-md-3 col-sm-3 float-left">
					{!! Html::linkRoute('diaries.mydiaries', 'My Diaries', array($user->id), array('class' => 'btn btn-info btn-block')) !!}
				</div>

				<div class="col-md-3 col-sm-3 float-left">
					{!! Html::linkRoute('users.description', 'About My Self', array($user->id), array('class' => 'btn btn-info btn-block')) !!}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('scripts')
<script type="text/javascript" src="{{ asset('js/main.js') }}" defer></script>
@endsection
