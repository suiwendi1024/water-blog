<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasComments
{
    /**
     * 可被评论的模型的评论。
     *
     * @return MorphMany
     */
    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    /**
     * 对可被评论的模型进行评论。
     *
     * @param string $body
     * @return Comment
     */
    public function comment(string $body): Comment
    {
        return $this->comments()->create([
            'user_id' => auth()->id(),
            'body' => $body,
        ])->load('owner')->loadCount('likes');
    }
}
