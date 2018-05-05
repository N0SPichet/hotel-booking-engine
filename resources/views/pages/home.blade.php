@extends('main')

@section('title','Home')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 col-lg-12 col-lg-offset-0 col-md-offset-0">
            <div class="panel panel-default">

              <div class="panel-body">

                <div class="w3-display-container">
                  <div class="w3-content">

                    @if ($houses != NULL)
                    @foreach ($houses as $house)
                      @if ($house->housetypes_id == 1 || $house->housetypes_id == 5)
                      <div class="col-sm-4 col-md-4 col-lg-4">
                        <div class="home_gallery" style="width: 100%; height: 300px;">
                            @if ($house->cover_image == NULL)
                              <img src="{{ asset('images/houses/default-room-picture.jpg') }}" class="img-responsive" style="border-radius: 2%">
                            @else
                              <a href="apartments/{{ $house->id }}"><img src="{{ asset('images/houses/'. $house->cover_image) }}" class="img-responsive" style="border-radius: 2%"></a>
                            @endif
                            <h5><img src="{{ asset('images/houses/apartment.png')}}" style="height: 20px; width: 20px; margin-bottom: 10px;"> <span class="home-room-guestspacing">{{ $house->house_guestspace }} space </span> {{ $house->house_title }}</h5>
                          
                        </div>
                        <small><p> at {{ $house->addresscities->city_name }} {{ $house->addressstates->state_name }},{{ $house->addresscountries->country_name }}</p></small>
                      </div>
                      @else
                      <div class="col-sm-4 col-md-4 col-lg-4">
                        <div class="home_gallery" style="width: 100%; height: 300px;">
                            @if ($house->cover_image == NULL)
                              <img src="{{ asset('images/houses/default-room-picture.jpg') }}" class="img-responsive" style="border-radius: 2%">
                            @else
                              <a href="rooms/{{ $house->id }}"><img src="{{ asset('images/houses/'. $house->cover_image) }}" class="img-responsive" style="border-radius: 2%"></a>
                            @endif
                            <h5><img src="{{ asset('images/houses/house.png')}}" style="height: 20px; width: 20px; margin-bottom: 10px;"> <span class="home-room-guestspacing">{{ $house->house_guestspace }} space</span> {{ $house->house_title }}</h5>
                          
                        </div>
                        <small><p>฿{{ $house->houseprices->price }} at {{ $house->addresscities->city_name }} {{ $house->addressstates->state_name }},{{ $house->addresscountries->country_name }}</p></small>
                      </div>
                      @endif

                    @endforeach
                    @else
                    <h4>No result</h4>
                    @endif

                  </div>
                </div>

              </div>
            
            </div>
        </div>
        <div class="text-center">
        @if ($houses != NULL)
        {!! $houses->links() !!}
        @endif
      </div>
    </div>
</div>
@endsection
