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
                            @if ($house->image_name == NULL)
                              <a href="rooms/{{ $house->id }}"><img src="{{ asset('images/houses/default-room-picture.jpg') }}" class="img-responsive"></a>
                            @else
                              <a href="rooms/{{ $house->id }}"><img src="{{ asset('images/houses/'. $house->image_name) }}" class="img-responsive"></a>
                            @endif
                            <span><h5>{{ $house->house_title }}</h5></span>
                        </div>
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
