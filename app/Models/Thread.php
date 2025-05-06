<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model {
    use HasFactory;
    protected $fillable = ['title','body','user_id','slug'];
    public function user()  { return $this->belongsTo(User::class); }
    public function posts() { return $this->hasMany(Post::class); }

    protected static function booted() {
        static::creating(fn($t) => $t->slug = Str::slug($t->title));
    }
}
