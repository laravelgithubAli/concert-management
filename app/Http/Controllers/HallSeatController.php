<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewHallSeatRequest;
use App\Http\Resources\HallResource;
use App\Http\Resources\HallSeatResource;
use App\Models\Hall;
use Illuminate\Http\Request;

class HallSeatController extends Controller
{
    /**
     * @param Hall $hall
     * @return \Illuminate\Http\JsonResponse|object
     */
    public function index(Hall $hall)
    {
        return response()->json([
            'data' => [
                'hall_seats' => new HallSeatResource($hall)
            ]
        ])->setStatusCode(200);
    }



    public function store(Hall $hall,NewHallSeatRequest $request)
    {
        $seats = $request->get('seats');

        $requestedSeatCount = collect($seats)->sum('seat_count');

        if ($requestedSeatCount > $hall->seat_count){
            return response()->json([
               'errors' => [
                   'request seat counts is greater than hall capacity '
               ]
            ])->setStatusCode(400);
        }



        foreach ($seats as $seat){

            $id = $seat['seat_class_id'];

            unset($seat['seat_class_id']);


            $hall->seats()->attach($id,$seat);
        }


        return response()->json([
            'data' => new HallSeatResource($hall)
        ])->setStatusCode(200);



    }


    public function update(Hall $hall,Request $request)
    {
        $hall->seats()->detach();

        $seats = $request->get('seats');

        $requestedSeatCount = collect($seats)->sum('seat_count');

        if ($requestedSeatCount > $hall->seat_count){
            return response()->json([
                'errors' => [
                    'request seat counts is greater than hall capacity '
                ]
            ])->setStatusCode(400);
        }



        foreach ($seats as $seat){

            $id = $seat['seat_class_id'];

            unset($seat['seat_class_id']);


            $hall->seats()->attach($id,$seat);
        }


        return response()->json([
            'data' => new HallSeatResource($hall)
        ])->setStatusCode(200);


    }



}
