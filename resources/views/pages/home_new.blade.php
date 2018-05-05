@extends('main')

@section('title','Home')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <h2>Promotions</h2>
      <div class="col-md-6">
        <p>No promotion now</p>
      </div>
    </div>
    
    <div class="home_gallery">
      <div class="col-md-12">
        <h2>Choose what you want</h2>
      </div>
      
      <div class="col-md-6">
        <a href="rooms"><img src="{{ asset('images/component/house.png') }}" class="img-responsive" style="margin-top: 100px; width: 500px;"></a>
      </div>
      <div class="col-md-6">
        <a href="apartments"><img src="{{ asset('images/component/apartment.png') }}" class="img-responsive"  style="width: 500px;"></a>
      </div>
    </div>
    
  </div>
</div>
@endsection
