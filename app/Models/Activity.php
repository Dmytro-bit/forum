<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use App\Traits\RecordsActivity;

class Activity extends Model
{
    protected $fillable = ['user_id', 'type', 'subject_type', 'subject_id', 'description'];

    public function subject(): MorphTo
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
