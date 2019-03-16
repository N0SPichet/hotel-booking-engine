@extends('dashboard.main')
@section('title', 'Dashboard | Account')

@section('content')
<div class="container dashboard-index users">
	<div class="col-md-3 float-left m-t-10">
		@include('layouts.side-tab-dashboard')
	</div>
	<div class="col-md-9 float-left m-t-10">
		<div class="card">
			<div class="card-title">
				<div class="col-md-12">
					<h4>{{ Auth::user()->user_fname }}'s Account @if (Auth::user()->hasRole('Admin'))<small>Role:{{Auth::user()->roles[0]->name}}</small>@endif @if (Auth::user()->verification->verify === '1') <span class="text-success"><i class="far fa-check-circle"></i> verifired</span> @else <span class="text-danger"><a href="{{ route('users.verify-user', Auth::user()->id) }}" class="btn btn-outline-danger"><i class="fa fa-exclamation-circle"></i> unverify</a></span>@endif</h4>
				</div>
			</div>
			<div class="card-text">
				@if (Auth::user()->verification->passport != null)
				<div class="col-md-12">
					<p>your passport : <b class="text-danger">{{ substr(Auth::user()->verification->passport, 9, 3) }}{{ substr(Auth::user()->verification->passport, 15, 3) }}{{ substr(Auth::user()->verification->passport, 12, 3) }}</b> keep it's secret</p>
					<p>your secret : <b class="text-danger">{{ Auth::user()->verification->secret }}</b> keep it's secret</p>
					<p>passport code you can use to identify yourself when checkin. please keep it's secret and don't tell anyone or hosts that you has rent their's home.</p>
				</div>
				@endif
				<div class="col-md-12 m-t-10" align="center">
					@if (Auth::user()->user_image == null)
					<img src="{{ asset('images/users/blank-profile-picture.png') }}" class="rounded-circle" style="width:150px; height: 150px; ">
					@else
					<img src="{{ asset('images/users/'. Auth::user()->id . '/' . Auth::user()->user_image) }}" class="rounded-circle" style="width:150px; height: 150px;">
					@endif

					{!! Form::open(['route' => ['users.updateimage', Auth::user()->id], 'files' => true]) !!}
						{{ Form::label('user_image', 'Profile Photo', array('class' => 'm-t-10 text-center')) }}
							
						<div class="fileupload fileupload-new text-center" data-provides="fileupload">
						    <span class="btn btn-primary btn-file">
						    	<span class="fileupload-new">Select file</span>
						    	<span class="fileupload-exists">Change</span>
						    	<input name="user_image" type="file" id="user_image">
						    </span>
						</div>
						{{ Form::submit('Update image', ['class' => 'btn btn-success']) }}
					{!! Form::close() !!}
				</div>
				<div class="col-md-12">
					<div class="margin-content">
						<p><b>Name</b> {{ Auth::user()->user_fname }} {{ Auth::user()->user_lname }}</p>
						<hr>

						@if (Auth::user()->user_tel !== null)
						<p><b>Phone Number</b> {{ Auth::user()->user_tel }}</p>
						<hr>
						@endif

						@if (Auth::user()->email != null)
						<p><b>Email</b> <a href="mailto:{{ Auth::user()->email }}">{{ Auth::user()->email }}</a></p>
						@endif

						@if (Auth::user()->user_gender != null)
						<p><b>Gender</b> <span id="gender">{{ Auth::user()->user_gender }}</span></p>
						<hr>
						@endif

						@if(Auth::user()->user_address != null || Auth::user()->sub_district_id != null || Auth::user()->district_id != null || Auth::user()->province_id != null)
						<p><b>Address</b><span>
							@if (Auth::user()->user_address !== null) {{ Auth::user()->user_address }} @endif
							@if (Auth::user()->sub_district->name !== null) {{ Auth::user()->sub_district->name }} @endif
							@if (Auth::user()->district->name !== null) {{ Auth::user()->district->name }}, @endif
							@if (Auth::user()->province->name !== null) {{ Auth::user()->province->name }} @endif
						</span></p>
						<hr>
						@endif

						@if (Auth::user()->user_description != null)
						<p><b>Description</b> {!! Auth::user()->user_description !!}</p>
						@endif
					</div>
					<div class="text-center">
						<a href="{{route('users.edit', Auth::user()->id)}}" class="btn btn-info">Update Account</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('scripts')
<script type="text/javascript" src="{{ asset('js/main.js') }}" defer></script>
@endsection
