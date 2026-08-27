<?php

namespace App\Repositories\Post;

use App\Models\Post;

class PostRepository implements PostRepositoryInterface
{
    public function all()
    {
        return Post::with(['user', 'comments.user'])->latest()->get();
    }

    public function find(int $id)
    {
        return Post::with(['user', 'comments.user'])->findOrFail($id);
    }

    public function create(array $data)
    {
        return Post::create($data)->load(['user', 'comments.user']);
    }

    public function update(Post $post, array $data)
    {
        $post->update($data);
        return $post->load(['user', 'comments.user']);
    }

    public function delete(Post $post)
    {
        return $post->delete();
    }
}
