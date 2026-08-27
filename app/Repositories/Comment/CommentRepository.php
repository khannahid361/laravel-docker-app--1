<?php

namespace App\Repositories\Comment;

use App\Models\Comment;

class CommentRepository implements CommentRepositoryInterface
{
    public function getByPostId(int $postId)
    {
        return Comment::where('post_id', $postId)->with('user')->latest()->get();
    }

    public function find(int $id)
    {
        return Comment::with('user')->findOrFail($id);
    }

    public function create(array $data)
    {
        return Comment::create($data)->load('user');
    }

    public function update(Comment $comment, array $data)
    {
        $comment->update($data);
        return $comment->load('user');
    }

    public function delete(Comment $comment)
    {
        return $comment->delete();
    }
}
