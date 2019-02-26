@extends('main')

@section('title','Contact Us')

@section('stylesheets')
	{{ Html::style('css/parsley.css') }}
@endsection

@section('content')

<div class="container">
	<div class="row m-t-10">
		<div class="col-md-12">
			<h1 class="title-page">Contact Us</h1>

			<form action="{{ route('postcontact') }}" method="POST">
				{{ csrf_field() }}
				<div class="form-group">
					<label name="email">Email</label>
					<input type="email" name="email" class="form-control">
				</div>

				<div class="form-group">
					<label name="subject">Subject</label>
					<input type="text" name="subject" class="form-control">
				</div>

				<div class="form-group">
					<label name="message">Message</label>
					<textarea name="message" class="form-control" rows="5"></textarea>
				</div>

				<input type="submit" value="Sent Message" class="btn btn-success">
			</form>
		</div>
	</div>
</div>
@endsection
