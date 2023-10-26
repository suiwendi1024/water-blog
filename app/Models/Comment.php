<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Comment extends Model
{
    use HasFactory;

    /**
     * 可批量指定的属性。
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'commentable_type',
        'commentable_id',
        'body',
    ];

    /**
     * 应该为序列化隐藏的属性。
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'user_id',
        'commentable_type',
        'commentable_id',
        'updated_at',
    ];

    /**
     * 应该强制转换的属性。
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
    ];

    /**
     * 应该在每个查询上加载的关系。
     *
     * @var array<int, string>
     */
    protected $with = [
        'owner',
        'commentable',
    ];

    /**
     * 发表评论的用户。
     *
     * @return BelongsTo
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * 评论的对象。
     *
     * @return MorphTo
     */
    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }
}
