<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewArtistRequest;
use App\Http\Requests\UpdateArtistRequest;
use App\Http\Resources\ArtistResource;
use App\Http\Resources\SingleArtistResource;
use App\Models\Artist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArtistController extends Controller
{


    public function store(NewArtistRequest $request)
    {


        $artistDirectory = $request->get('full_name').now()->timestamp;

       $avatar =  $this->uploader($request,"public/artist/{$artistDirectory}");

       $background = $this->uploader($request,"public/artist/{$artistDirectory}");

//        $avatar = $request->file('avatar')->storePubliclyAs('public/artists/'.$artistDirectory,
//        $request->file('avatar')->getClientOriginalName()
//        );

//        $background = $request->file('background')->storePubliclyAs('public/backgrounds/'.$artistDirectory,
//        $request->file('background')->getClientOriginalName());


       $artist = Artist::query()->create([
            'full_name' => $request->get('full_name'),
            'category_id' => $request->get('category_id'),
            'avatar' => $avatar,
            'background' => $background,
        ]);

        return response()->json([
            'data' => [
                'artist' => new SingleArtistResource($artist)
            ]
        ])->setStatusCode(201);
    }


    /**
     * @return \Illuminate\Http\JsonResponse|object
     *
     */

    public function index()
    {
        return response()->json([
            'data' => [
                'artist' => ArtistResource::collection(Artist::paginate(5))->response()->getData()
            ]
        ])->setStatusCode(200);
    }





    public function update(Artist $artist,UpdateArtistRequest $request)
    {

//        dd($artist->avatar);
//        dd(explode('/',$artist->avatar));
        $directory = explode('/',$artist->avatar);

        array_pop($directory);

        $artistDirectory = implode('/',$directory);

//        dd($artistDirectory);

//        dd(array_pop($directory),$directory);

        if ($request->hasFile('avatar')){

            $avatar = $this->uploader($request,$artistDirectory,'avatar');
            Storage::delete($artist->avatar);

        }else{

            $avatar = $artist->avatar;

        }

        if ($request->hasFile('background')){
            $backgroound = $this->uploader($request,$artistDirectory,'background');
            Storage::delete($artist->avatar);
        }else{
            $background = $artist->background;
        }

        $artist->update([
           'full_name' => $request->get('full_name',$artist->full_name),
           'category_id' => $request->get('category_id',$artist->category_id),
           'avatar' => $avatar,
           'background' => $background,
        ]);

        return response()->json([
            'data' => [
                'artist' => new ArtistResource($artist)
            ]
        ])->setStatusCode(201);

    }


    public function show(Artist $artist)
    {
        return response()->json([
            'data' => new ArtistResource($artist)
        ])->setStatusCode(200);
    }

    public function destroy(Artist $artist)
    {

        Storage::delete($artist->avatar);
        Storage::delete($artist->background);

        $artist->delete();

        return response([
            'message' => 'با موفقیت حذف شد...'
        ]);
    }
}
