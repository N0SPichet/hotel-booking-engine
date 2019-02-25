@extends('main')
@section('title','Home')
@section('content')
<div class="container">
    <div class="row m-t-10">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    @if ($houses->count() > 0)
                    @foreach ($houses as $house)
                    <div class="col-sm-4 col-md-4 col-lg-4 float-left">
                        <div class="margin-content box home">
                            <div class="img-box" style="margin-bottom: 5px;">
                            @if ($house->cover_image == NULL)
                                <img src="{{ asset('images/houses/default-room-picture.jpg') }}" class="img-responsive" style="border-radius: 2%">
                            @else
                                @if ($house->checkType($house->id))
                                <a href="{{ route('rooms.show', $house->id) }}"><img src="{{ asset('images/houses/'.$house->id.'/'. $house->cover_image) }}" class="img-responsive" style="border-radius: 2%"></a>
                                @else
                                <a href="{{ route('apartments.show', $house->id) }}"><img src="{{ asset('images/houses/'.$house->id.'/'. $house->cover_image) }}" class="img-responsive" style="border-radius: 2%"></a>
                                @endif
                            @endif
                            </div>
                        @if ($house->checkType($house->id))
                            <h5><img src="{{ asset('images/houses/house.png')}}" style="height: 20px; width: 20px; margin-bottom: 10px;"> <span class="home-room-guestspacing">{{ $house->house_guestspace }} space</span> {{ $house->house_title }}</h5>
                            <small>
                                <p>฿{{ $house->houseprices->price }} at {{ $house->sub_district->name }} {{ $house->district->name }},{{ $house->province->name }}</p>
                            </small>
                        </div>
                        @else
                            <h5><img src="{{ asset('images/houses/apartment.png')}}" style="height: 20px; width: 20px; margin-bottom: 10px;"> <span class="home-room-guestspacing">{{ $house->house_guestspace }} space </span> {{ $house->house_title }}</h5>
                            <small>
                                <p> at {{ $house->sub_district->name }} {{ $house->district->name }},{{ $house->province->name }}</p>
                            </small>
                        </div>
                        @endif
                    </div>
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
