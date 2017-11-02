@extends('main')

@section('title','Home')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 col-md-offset-0">
            <div class="panel panel-default">
              <div class="panel-heading"><h4>Home</h4></div>

              <div class="panel-body">

                <div class="w3-display-container">
                  <div class="w3-content">

                    @foreach ($houses as $house)
                      
                      <div class="col-sm-6 col-md-6 col-lg-6">
                        <div class="rooms">
                            
                            <!-- <a href="rooms/{{ $house->id }}"><img src="http://cdn-image.travelandleisure.com/sites/default/files/styles/1600x1000/public/hotel-interior-room0416.jpg?itok=5gENxAK1" class="img-responsive"></a>
                            <span><h5>{{ $house->house_title }}</h5></span> -->

                            <a href="rooms/{{ $house->id }}"><img src="https://www.proprofs.com/flashcards/topic/images/p1bi8acpumdi81kqp1kmq1hop1kp3.jpg" class="img-responsive"></a>
                            <span><h5>{{ $house->house_title }}</h5></span>

                        </div>

                       <!--  @foreach ($images as $image)
                            @if ($image->houses_id == $house->id)
                              <a href="rooms/{{ $house->id }}"><img src="{{ asset('images/houses/' . $image->image_name) }}" class="img-responsive"></a>
                            @endif
                        @endforeach -->
                      </div>

                    @endforeach

                  </div>
                </div>

              </div> <!-- end of panel body-->
            
            </div>
        </div>
        <div class="text-center">
        <!-- generate link for siary item -->
        {!! $houses->links() !!}
      </div>
    </div> <!-- end of row-->
</div>
@endsection
