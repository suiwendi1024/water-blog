<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Post extends Model
{
    use HasFactory;

    /**
     * 可批量指定的属性。
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'body',
    ];

    /**
     * 要在每个查询上加载的关系。
     *
     * @var array<int, string>
     */
    protected $with = [
        'author',
        'category',
    ];

    /**
     * 帖子的作者。
     *
     * @return BelongsTo
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * 帖子的分类。
     *
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * 帖子的评论。
     *
     * @return MorphMany
     */
    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    /**
     * 从帖子的正文提取帖子的开头。
     *
     * @return Attribute
     */
    protected function beginning(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => substr(strip_tags($attributes['body']), 0, 200),
        );
    }

    /**
     * 帖子的链接。
     *
     * @return Attribute
     */
    protected function href(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value) => route('posts.show', ['post' => $this->id]),
        );
    }
}
