<?php

namespace App\Http\Controllers;

use App\Http\Middleware\CheckAccessMiddleware;
use App\Http\Requests\NewCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{



    public function index()
    {
        return response()->json([
           'data' => CategoryResource::collection(Category::paginate(10))
        ])->setStatusCode(200);
    }



    public function store(Request $request)
    {

        if (! auth()->user()->tokenCan('creat-categories')) {
            abort(403);
        }


      $category = Category::query()->create([
           'title' => $request->get('title')
        ]);

        return response()->json([
           'data' => new CategoryResource($category)
        ])->setStatusCode(201);
    }


    public function update(Category $category,NewCategoryRequest $request)
    {

        if (! auth()->user()->tokenCan('edit-categories')){
            abort(403);
        }

        $category->update([
           'title' => $request->get('title')
        ]);

        return response()->json([
            'data' =>  new CategoryResource($category)
        ])->setStatusCode(200);
    }



    public function show(Category $category)
    {
        return response()->json([

           'data' => new CategoryResource($category)

        ])->setStatusCode(200);
    }



    public function destroy(Category $category)
    {
        $category->delete();

        return response()->json([
           'message' => 'با موفقیت حذف شد!!!'
        ])->setStatusCode(200);
    }
}
