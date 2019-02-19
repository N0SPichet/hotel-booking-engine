@extends('main')

@section('title','User Verification')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default col">
                <div class="panel-heading">User Verification</div>
                <div class="panel-body">
                    <!-- <p style="color: red;">all information must be true</p> -->
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('users.verify-request') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                       
                        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                            <label for="title" class="col-md-4 control-label">Title</label>

                            <div class="col-md-6">
                                <select id="title" type="select" class="form-control" name="title" value="{{ old('title') }}" required autofocus>
                                    <option value="Mr." {{ Auth::user()->verification->title === 'Mr.' ? 'selected':'' }}>Mr.</option>
                                    <option value="Mrs." {{ Auth::user()->verification->title === 'Mrs.' ? 'selected':'' }}>Mrs.</option>
                                    <option value="Ms." {{ Auth::user()->verification->title === 'Ms.' ? 'selected':'' }}>Ms.</option>
                                    <option value="Miss." {{ Auth::user()->verification->title === 'Miss.' ? 'selected':'' }}>Miss.</option>
                                    <option value="Dr." {{ Auth::user()->verification->title === 'Dr.' ? 'selected':'' }}>Dr.</option>
                                    <option value="Prof." {{ Auth::user()->verification->title === 'Prof.' ? 'selected':'' }}>Prof.</option>
                                </select>

                                @if ($errors->has('title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ Auth::user()->verification->name}}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="in-line form-group{{ $errors->has('lastname') ? ' has-error' : '' }}">
                            <label for="lastname" class="col-md-4 control-label">Last Name</label>

                            <div class="col-md-6">
                                <input id="lastname" type="text" class="form-control" name="lastname" value="{{ Auth::user()->verification->lastname}}" required autofocus>

                                @if ($errors->has('lastname'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('lastname') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('id_card') ? ' has-error' : '' }}">
                            <label for="id_card" class="col-md-4 control-label">ID Card</label>

                            <div class="col-md-6">
                                <input id="id_card" type="file" class="" name="id_card" value="{{ old('id_card') }}" required autofocus>

                                @if ($errors->has('id_card'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('id_card') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('census_registration') ? ' has-error' : '' }}">
                            <label for="census_registration" class="col-md-4 control-label">Census Registration</label>

                            <div class="col-md-6">
                                <input id="census_registration" type="file" class="" name="census_registration" value="{{ old('census_registration') }}" required autofocus>

                                @if ($errors->has('census_registration'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('census_registration') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <p>If it <b><span style="color: green;">pass</span></b> this is the only once and you will never edit or change this if you have to change please <a href="#">contact support</a></p>
                                <p>but if it <b><span style="color: red;">not pass</span></b> you can change or try to send again. so all of information it must be true.</p>
                                <p>Thank you with Love from <b><span style="color: orange;">LTT</span></b></p>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Send request
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
