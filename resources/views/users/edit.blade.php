@extends ('main')
@section ('title', 'Edit My Account')
@section('stylesheets')
{{ Html::style('css/parsley.css') }}
<script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=qei14aeigd6p0lkquybi330fte0vp7ne9ullaou6d5ti437y"></script>
<script>
	tinymce.init({ 
		selector:'textarea',
		menubar: false
	});
</script>
@endsection

@section ('content')
<div class="container">
	<div class="row m-t-10">
		{!! Form::model($user, ['route' => ['users.update', $user->id], 'method' => 'PUT']) !!}
			{{ csrf_field() }}		
		<div class="col-md-6 float-left">
			{{ Form::label('user_fname', 'Name', array('class' => 'm-t-10')) }}
			{{ Form::text('user_fname', null, ['class' => 'form-control input-md']) }}

			{{ Form::label('user_lname', 'Last Name', array('class' => 'm-t-10')) }}
			{{ Form::text('user_lname', null, ['class' => 'form-control input-md']) }}

			{{ Form::label('user_tel', 'Phone Number', array('class' => 'm-t-10')) }}
			{{ Form::text('user_tel', null, ['class' => 'form-control input-md']) }}

			{{ Form::label('user_address', 'Address', array('class' => 'm-t-10')) }}
			{{ Form::text('user_address', null, ['class' => 'form-control input-md']) }}

			{{ Form::label('province_id', 'Provinces', array('class' => 'm-t-10')) }}
			<select id="province_id" class="form-control input-md m-t-10" name="province_id">
				<option value="0">Select Provinces</option>
				@foreach ($provinces as $province)
				@if($user->province_id !== null)
				<option value="{{ $province->id }}" {{ $province->id===$user->province_id? 'selected':'' }}>{{ $province->name }}</option>
				@else
				<option value="{{ $province->id }}" {{ $province->id===1? 'selected':'' }}>{{ $province->name }}</option>
				@endif
				@endforeach
			</select>

			{{ Form::label('district_id', 'Districts', array('class' => 'm-t-10')) }}
			<select id="district_id" class="form-control input-md m-t-10" name="district_id">
				<option value="0">Select Districts</option>
				@foreach ($districts as $district)
				@if($user->district_id !== null)
				<option value="{{ $district->id }}" {{ $district->id===$user->district_id? 'selected':'' }}>{{ $district->name }}</option>
				@else
				<option value="{{ $district->id }}" {{ $district->id===1? 'selected':'' }}>{{ $district->name }}</option>
				@endif
				@endforeach
			</select>

			{{ Form::label('sub_district_id', 'Sub Districts', array('class' => 'm-t-10')) }}
			<select id="sub_district_id" class="form-control input-md m-t-10" name="sub_district_id">
				<option value="0">Select Sub Districts</option>
				@foreach ($sub_districts as $sub_district)
				@if($user->sub_district_id !== null)
				<option value="{{ $sub_district->id }}" {{ $sub_district->id===$user->sub_district_id? 'selected':'' }}>{{ $sub_district->name }}</option>
				@else
				<option value="{{ $sub_district->id }}" {{ $sub_district->id===1? 'selected':'' }}>{{ $sub_district->name }}</option>
				@endif
				@endforeach
			</select>
		</div>

		<div class="col-md-6 float-left">
			{{ Form::label('user_gender', 'Gender', array('class' => 'm-t-10')) }}
			<select class="form-control input-md" name="user_gender">
				<option value="0" {{ $user->user_gender===null ? 'selected':'' }}>Select Gender</option>
				<option value="1" {{ $user->user_gender==='1' ? 'selected'  : '' }}>Male</option>
				<option value="2" {{ $user->user_gender==='2' ? 'selected'  : '' }}>Female</option>
			</select>

			{{ Form::label('user_description', 'Describe your self', array('class' => 'm-t-10')) }}
			{{ Form::textarea('user_description', null, ['class' => 'form-control input-md form-spacing-top']) }}
		</div>
	</div>
	<div class="row">
		<div class="col-md-12 center">
			<div class="col-sm-6 col-md-6 float-left">
				{!! Html::linkRoute('users.profile', 'Back to My Account', array($user->id), array('class' => 'btn btn-info btn-block btn-h1-spacing')) !!}
			</div>

			<div class="col-sm-6 col-md-6 float-left">
				{{ Form::submit('Update', ['class' => 'btn btn-success btn-block btn-h1-spacing']) }}
			</div>
		</div>

		{!! Form::close() !!}
	</div>
</div>
@endsection
@section('scripts')
{!! Html::script('js/parsley.min.js') !!}
<script type="text/javascript">
	$(document).ready(function() {
		$('#province_id').on('change', function() {
			var p_id = $(this).val();
			var url = "{{ route('api.get.province', ":id") }}";
			url = url.replace(':id', p_id);
			$.ajax({
				type: "get",
				url: url,
				data: {},
				success: function (response) {
					$('#district_id').empty();
					$('#district_id').append('<option value="0">Select Districts</option>');
					$('#sub_district_id').empty();
					$('#sub_district_id').append('<option value="0">Select Sub Districts</option>');
					$.each(response.data, function(index, data) {
						$('#district_id').append('<option value="'+data.id+'">'+data.name+'</option>');
					});
				}
			});
		});

		$('#district_id').on('change', function() {
			var d_id = $(this).val();
			var url = "{{ route('api.get.district', ":id") }}";
			url = url.replace(':id', d_id);
			$.ajax({
				type: "get",
				url: url,
				data: {},
				success: function (response) {
					$('#sub_district_id').empty();
					$('#sub_district_id').append('<option value="0">Select Sub Districts</option>');
					$.each(response.data, function(index, data) {
						$('#sub_district_id').append('<option value="'+data.id+'">'+data.name+'</option>');
					});
				}
			});
		});
	});
</script>
<script type="text/javascript" src="{{asset('js/main.js')}}"></script>
@endsection
