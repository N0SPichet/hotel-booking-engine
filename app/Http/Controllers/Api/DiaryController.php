<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Diary;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DiaryController extends Controller
{
    /**
     * toggle publish flag to the diary.
     *
     * @return \Illuminate\Http\Response
     */
    public function togglePublish(Diary $diary, Request $request)
    {
        if ($diary->publish != $request->flag) {
            $diary->publish = $request->flag;
        }
        $diary->save();
        return response()->json([
            'data' => $diary->publish
        ], Response::HTTP_CREATED);
    }
}
