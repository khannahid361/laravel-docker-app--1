<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StorePostRequest;
use App\Http\Requests\Api\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Services\PostService;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct(
        protected PostService $postService
    ) {}

    public function index()
    {
        $posts = $this->postService->getAllPosts();

        return response()->json([
            'success' => true,
            'message' => 'Posts retrieved successfully',
            'data' => PostResource::collection($posts),
        ]);
    }

    public function show(int $id)
    {
        $post = $this->postService->getPostById($id);

        return response()->json([
            'success' => true,
            'message' => 'Post retrieved successfully',
            'data' => new PostResource($post),
        ]);
    }

    public function store(StorePostRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = $request->user()->id;

        $post = $this->postService->createPost($data);

        return response()->json([
            'success' => true,
            'message' => 'Post created successfully',
            'data' => new PostResource($post),
        ], 201);
    }

    public function update(UpdatePostRequest $request, int $id)
    {
        $post = $this->postService->getPostById($id);

        Gate::authorize('update', $post);

        $data = $request->validated();
        $updatedPost = $this->postService->updatePost($post, $data);

        return response()->json([
            'success' => true,
            'message' => 'Post updated successfully',
            'data' => new PostResource($updatedPost),
        ]);
    }

    public function destroy(int $id)
    {
        $post = $this->postService->getPostById($id);

        Gate::authorize('delete', $post);

        $this->postService->deletePost($post);

        return response()->json([
            'success' => true,
            'message' => 'Post deleted successfully',
            'data' => null,
        ]);
    }
}
