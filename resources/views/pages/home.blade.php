@extends('main')

@section('title','Home')

@section('content')
<div class="container">
    <div class="row m-t-10">
        <div class="col-md-12">
            <div class="card">
              <div class="card-body">
                    @if ($houses != NULL)
                    @foreach ($houses as $house)
                      @if ($house->housetypes_id == 2 || $house->housetypes_id == 3)
                      <div class="col-sm-4 col-md-4 col-lg-4 float-left">
                        <div class="home_gallery" style="width: 100%; height: 300px;">
                            @if ($house->cover_image == NULL)
                              <img src="{{ asset('images/houses/default-room-picture.jpg') }}" class="img-responsive" style="border-radius: 2%">
                            @else
                              <a href="apartments/{{ $house->id }}"><img src="{{ asset('images/houses/'.$house->id.'/'. $house->cover_image) }}" class="img-responsive" style="border-radius: 2%"></a>
                            @endif
                            <h5><img src="{{ asset('images/houses/apartment.png')}}" style="height: 20px; width: 20px; margin-bottom: 10px;"> <span class="home-room-guestspacing">{{ $house->house_guestspace }} space </span> {{ $house->house_title }}</h5>
                          
                        </div>
                        <small><p> at {{ $house->sub_district->name }} {{ $house->district->name }},{{ $house->province->name }}</p></small>
                      </div>
                      @else
                      <div class="col-sm-4 col-md-4 col-lg-4 float-left">
                        <div class="home_gallery" style="width: 100%; height: 300px;">
                            @if ($house->cover_image == NULL)
                              <img src="{{ asset('images/houses/default-room-picture.jpg') }}" class="img-responsive" style="border-radius: 2%">
                            @else
                              <a href="rooms/{{ $house->id }}"><img src="{{ asset('images/houses/'.$house->id.'/'. $house->cover_image) }}" class="img-responsive" style="border-radius: 2%"></a>
                            @endif
                            <h5><img src="{{ asset('images/houses/house.png')}}" style="height: 20px; width: 20px; margin-bottom: 10px;"> <span class="home-room-guestspacing">{{ $house->house_guestspace }} space</span> {{ $house->house_title }}</h5>
                          
                        </div>
                        <small><p>฿{{ $house->houseprices->price }} at {{ $house->sub_district->name }} {{ $house->district->name }},{{ $house->province->name }}</p></small>
                      </div>
                      @endif

                    @endforeach
                    @else
                    <h4>No result</h4>
                    @endif
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
