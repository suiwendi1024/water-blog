<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * 用户创建的帖子。
     *
     * @return HasMany
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    /**
     * 用户发表的评论。
     *
     * @return HasMany
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * 用户发出的关注。
     *
     * @return HasMany
     */
    public function follows(): HasMany
    {
        return $this->hasMany(Follow::class);
    }

    /**
     * 用户收到的关注。
     *
     * @return HasMany
     */
    public function receivedFollows(): HasMany
    {
        return $this->hasMany(Follow::class, 'followee_id');
    }

    /**
     * 关注该用户。
     *
     * @return void
     */
    public function follow(): void
    {
        if (!$this->isFollowed) {
            $this->receivedFollows()->create([
                'user_id' => auth()->id(),
            ]);
        }
    }

    /**
     * 取消关注该用户。
     *
     * @return void
     */
    public function unfollow(): void
    {
        if ($this->isFollowed) {
            $this->receivedFollows()->where([
                'user_id' => auth()->id(),
            ])->delete();
        }
    }

    /**
     * 判断该用户是否被关注。
     *
     * @return Attribute
     */
    protected function isFollowed(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value) => (bool)$this->receivedFollows()->where([
                'user_id' => auth()->id(),
            ])->first(),
        );
    }
}
