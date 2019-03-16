@extends('admin.layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="container dashboard-index">
    <div class="row m-t-10">
        <div class="col-md-3 m-t-10">
            @include('admin.layouts.side-tab-dashboard')
        </div>
        <div class="col-md-9 m-t-10">
            <div class="panel panel-default">
                <div class="panel-heading"><h4>{{ Auth::user()->name }}'s Dashboard</h4></div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p>Welcome : <strong>{{ Auth::user()->name}}</strong></p>
                    <p>Your joined  : {{ Auth::user()->created_at->diffForHumans() }} </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
