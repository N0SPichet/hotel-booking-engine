<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\House;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoomController extends Controller
{
    /**
     * toggle publish flag to the room.
     *
     * @return \Illuminate\Http\Response
     */
    public function togglePublish(House $house)
    {
        if ($house->publish == '1') {
            $house->publish = '0';
        }
        elseif ($house->publish == '0') {
            $house->publish = '1';
        }
        $house->save();
        return response()->json([
            'data' => $house->publish
        ], Response::HTTP_CREATED);
    }
}
