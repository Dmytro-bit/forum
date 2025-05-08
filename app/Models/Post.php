<?php

namespace App\Models;
// comment
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\RecordsActivity;

class Post extends Model
{
    use HasFactory;
    use RecordsActivity;

    protected $fillable = [
        'content',
        'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getBodyAttribute(): string
    {
        return $this->attributes['content'];
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function thread(): BelongsTo
    {
        return $this->belongsTo(Thread::class);
    }

    public function getAvatarUrlAttribute(): string
    {
        return $this->user->avatar_path
            ? Storage::url($this->user->avatar_path)
            : '/images/default-avatar.png';
    }
}
