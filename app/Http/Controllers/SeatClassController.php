<?php

namespace App\Http\Controllers;

use App\Http\Resources\SeatClassResource;
use App\Models\SeatClass;
use Illuminate\Http\Request;

class SeatClassController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => [
                'seat_classes' => SeatClassResource::collection(SeatClass::all())
            ]
        ])->setStatusCode(200);
    }
}
