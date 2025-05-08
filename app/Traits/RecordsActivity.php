<?php

namespace App\Traits;

use App\Models\Activity;

trait RecordsActivity
{
    protected static function bootRecordsActivity()
    {
        static::created(function ($model) {
            $model->recordActivity('created');
        });
    }

    public function activities()
    {
        return $this->morphMany(Activity::class, 'subject');
    }

    protected function recordActivity(string $type)
    {
        Activity::create([
            'user_id' => auth()->id(),
            'type' => $type . '_' . strtolower(class_basename($this)),
            'subject_type' => get_class($this),
            'subject_id' => $this->id,
            'description' => $this->getActivityDescription($type)
        ]);
    }

    protected function getActivityDescription(string $type): string
    {
        return match ($type) {
            'created' => $this->getCreatedActivityDescription(),
            default => $type . ' ' . strtolower(class_basename($this))
        };
    }

    protected function getCreatedActivityDescription(): string
    {
        return "created " . strtolower(class_basename($this));
    }
}
