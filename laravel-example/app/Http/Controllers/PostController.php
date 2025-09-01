<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StorePostRequest;

class PostController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       return $this->ok("Todo ok, como dijo el Pibe", Post::get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $data = $request->validated();
        $newPost = Post::create($data);
        return $this->ok("Todo melo", [$newPost]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $result = Post::find($id);
        if ($result){
            return $this->ok("Todo ok, como dijo el Pibe", $result);
        }else{
            return $this->success("Todo mal, como no dijo el Pibe", [], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
