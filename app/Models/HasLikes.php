<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasLikes
{
    /**
     * 模型被删除时，先逐一删除其点赞。
     *
     * @return void
     */
    protected static function bootHasLikes(): void
    {
        static::deleting(function ($model) {
            return $model->likes->map->delete();
        });
    }

    /**
     * 可被点赞的模型的点赞。
     *
     * @return MorphMany
     */
    public function likes(): MorphMany
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    /**
     * 对可被点赞的模型进行点赞。
     *
     * @return void
     */
    public function like(): void
    {
        if (!$this->isLiked) {
            $this->likes()->create([
                'user_id' => auth()->id(),
            ]);
        }
    }

    /**
     * 对可被点赞的模型取消点赞。
     *
     * @return void
     */
    public function unlike(): void
    {
        if ($this->isLiked) {
            $this->likes()->where([
                'user_id' => auth()->id(),
            ])->delete();
        }
    }

    /**
     * 判断可被点赞的模型是否被点赞。
     *
     * @return Attribute
     */
    protected function isLiked(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value) => (bool)$this->likes()->where([
                'user_id' => auth()->id(),
            ])->first(),
        );
    }
}
