<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\PostalCode;
use App\Models\Province;
use App\Models\SubDistrict;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $provices = Province::all();
        return response()->json([
            'data' => $provices
        ], Response::HTTP_CREATED);
    }

    public function provices(Province $province)
    {
        return response()->json([
            'data' => $province
        ], Response::HTTP_CREATED);
    }

    public function getProvices(Province $province)
    {
        return response()->json([
            'data' => $province->districts
        ], Response::HTTP_CREATED);
    }

    public function districts(District $district)
    {
        return response()->json([
            'data' => $district
        ], Response::HTTP_CREATED);
    }

    public function getDistricts(District $district)
    {
        return response()->json([
            'data' => $district->sub_districts
        ], Response::HTTP_CREATED);
    }

    public function sub_districts(SubDistrict $sub_district)
    {
        return response()->json([
            'data' => $sub_district
        ], Response::HTTP_CREATED);
    }

    public function postalCode(PostalCode $postalcode)
    {
        return response()->json([
            'data' => $postalcode
        ], Response::HTTP_CREATED);
    }

    public function getPostalCode(SubDistrict $subdistrict)
    {
        return response()->json([
            'data' => $subdistrict->postal_code
        ], Response::HTTP_CREATED);
    }

    public function searchPostalCode($postalcode)
    {
        $postalcode = PostalCode::where('code', $postalcode)->get();
        return response()->json([
            'data' => $postalcode
        ], Response::HTTP_CREATED);
    }
}
