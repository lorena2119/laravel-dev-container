<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Http\Resources\PostResource;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\JsonResponse;

class PostController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
       $posts = Post::with('user', 'categories')->get();
       return $this->success(PostResource::collection($posts));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request): JsonResponse
    {
        $data = $request->validated();

        // Body no v a a recibir id del usuario
        $data['user_id'] = $request->user()->id; // Siempre se toma del token

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] =$request->file('cover_image')->store('posts', 'public');
        }
        
        $newPost = Post::create($data);

        if (!empty($data['category_ids'])) {
            $newPost->categories()->sync($data['category_ids']);
        }

        $newPost->load(['user', 'categories']);
        return $this->success(new PostResource($newPost), 'Post creado correctamente', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse //Post $post
    {
        $result = Post::find($id);
        if ($result){
            $result->load(['user', 'categories']);
            return $this->success(new PostResource($result), "Todo ok, como dijo el Pibe");
        }else{
            return $this->error("Todo mal, como no dijo el Pibe", 404, ['id' => 'No se encontró el id']);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post): JsonResponse
    {
        $data = $request->validated();

        if ($request->hasFile('cover_image')) {
            if ($post->cover_image) {
                Storage::disk('public')->delete($post->cover_image);
            }
            $data['cover_image'] =$request->file('cover_image')->store('posts', 'public');
        }
        $post->update($data);

        if (array_key_exists('category_ids', $data)) {
            $post->categories()->sync($data['category_ids'] ?? []);
        }

        $post->load(['user', 'categories']);
        return $this->success(new PostResource($post));
    }

    /**
     * Remove the specified resource from storage.
     */
    
    public function destroy(Post $post): JsonResponse
    {
        $post->delete(); // Soft Delete
        return $this->success(null, 'Post eliminado', 204);
    }

    public function restore(int $id): JsonResponse{
        $post = Post::onlyTrashed()->findOrFail($id);
        if (!$post) {
            $this->success(new PostResource($newPost), 'Post no encontrado', 201);
        }

        $post->restore();
        $post->load(['user', 'categories']);
        return $this->success($post, 'Post restaurado correctamente');
    }
}
