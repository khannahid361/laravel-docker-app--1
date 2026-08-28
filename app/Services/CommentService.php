<?php

namespace App\Services;

use App\Models\Comment;
use App\Repositories\Comment\CommentRepositoryInterface;

class CommentService
{
    public function __construct(
        protected CommentRepositoryInterface $commentRepository
    ) {}

    public function getCommentsByPostId(int $postId)
    {
        return $this->commentRepository->getByPostId($postId);
    }

    public function getCommentById(int $id)
    {
        return $this->commentRepository->find($id);
    }

    public function createComment(array $data)
    {
        return $this->commentRepository->create($data);
    }

    public function updateComment(Comment $comment, array $data)
    {
        return $this->commentRepository->update($comment, $data);
    }

    public function deleteComment(Comment $comment)
    {
        return $this->commentRepository->delete($comment);
    }
}
