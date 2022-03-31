<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewHallRequest;
use App\Http\Requests\UpdateHallRequest;
use App\Http\Resources\HallResource;
use App\Models\Hall;
use Illuminate\Http\Request;

class HallController extends Controller
{

    public function index()
    {
        return response()->json([
           'data' => [
               'halls' => HallResource::collection(Hall::paginate(5))->response()->getData()
           ]
        ])->setStatusCode(200);
    }



    public function store(NewHallRequest $request)
    {
        $hall = Hall::query()->create([
           'name' => $request->get('name'),
           'seat_count' => $request->get('seat_count')
        ]);

        return response()->json([
            'data' => [
                'hall' => new HallResource($hall)
            ]
        ])->setStatusCode(200);
    }



    public function show(Hall $hall)
    {
        return response()->json([
           'data' => [
               'hall' => new HallResource($hall)
           ]
        ])->setStatusCode(200);
    }


    public function update(Hall $hall,UpdateHallRequest $request)
    {
      $hall->update([
           'name' => $request->get('name',$hall->name),
           'seat_count' => $request->get('seat_count',$hall->seat_count)
        ]);

      return response()->json([
         'data' => [
             'updateHall' => new HallResource($hall)
         ]
      ])->setStatusCode(200);
    }


    public function destroy(Hall $hall)
    {
        $hall->delete();

        return response()->json([
           'data' => [
               'message' => 'hall been  deleted!!!'
           ]
        ])->setStatusCode(200);
    }

}
