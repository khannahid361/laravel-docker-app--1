<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreCommentRequest;
use App\Http\Requests\Api\UpdateCommentRequest;
use App\Http\Resources\CommentResource;
use App\Services\CommentService;
use App\Services\PostService;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function __construct(
        protected CommentService $commentService,
        protected PostService $postService
    ) {}

    public function index(int $postId)
    {
        // Verify post exists
        $this->postService->getPostById($postId);

        $comments = $this->commentService->getCommentsByPostId($postId);

        return response()->json([
            'success' => true,
            'message' => 'Comments retrieved successfully',
            'data' => CommentResource::collection($comments),
        ]);
    }

    public function store(StoreCommentRequest $request, int $postId)
    {
        // Verify post exists
        $this->postService->getPostById($postId);

        $data = $request->validated();
        $data['post_id'] = $postId;
        $data['user_id'] = $request->user()->id;

        $comment = $this->commentService->createComment($data);

        return response()->json([
            'success' => true,
            'message' => 'Comment created successfully',
            'data' => new CommentResource($comment),
        ], 201);
    }

    public function update(UpdateCommentRequest $request, int $id)
    {
        $comment = $this->commentService->getCommentById($id);

        Gate::authorize('update', $comment);

        $data = $request->validated();
        $updatedComment = $this->commentService->updateComment($comment, $data);

        return response()->json([
            'success' => true,
            'message' => 'Comment updated successfully',
            'data' => new CommentResource($updatedComment),
        ]);
    }

    public function destroy(int $id)
    {
        $comment = $this->commentService->getCommentById($id);

        Gate::authorize('delete', $comment);

        $this->commentService->deleteComment($comment);

        return response()->json([
            'success' => true,
            'message' => 'Comment deleted successfully',
            'data' => null,
        ]);
    }
}
