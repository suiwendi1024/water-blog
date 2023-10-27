<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Follow extends Model
{
    use HasFactory;

    /**
     * 可批量指定的属性。
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'followee_id',
    ];

    /**
     * 关注其他用户的用户。
     *
     * @return BelongsTo
     */
    public function follower(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * 关被关注的用户。
     *
     * @return BelongsTo
     */
    public function followee(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
