<?php

namespace App\Services;

use App\Models\Post;
use App\Repositories\Post\PostRepositoryInterface;

class PostService
{
    public function __construct(
        protected PostRepositoryInterface $postRepository
    ) {}

    public function getAllPosts()
    {
        return $this->postRepository->all();
    }

    public function getPostById(int $id)
    {
        return $this->postRepository->find($id);
    }

    public function createPost(array $data)
    {
        return $this->postRepository->create($data);
    }

    public function updatePost(Post $post, array $data)
    {
        return $this->postRepository->update($post, $data);
    }

    public function deletePost(Post $post)
    {
        return $this->postRepository->delete($post);
    }
}
