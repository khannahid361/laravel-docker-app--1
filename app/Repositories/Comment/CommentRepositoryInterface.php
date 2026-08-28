<?php

namespace App\Repositories\Comment;

use App\Models\Comment;

interface CommentRepositoryInterface
{
    public function getByPostId(int $postId);

    public function find(int $id);

    public function create(array $data);

    public function update(Comment $comment, array $data);

    public function delete(Comment $comment);
}
