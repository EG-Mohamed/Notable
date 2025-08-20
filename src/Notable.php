<?php

namespace MohamedSaid\Notable;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Notable extends Model
{
    public function getTable()
    {
        return config('notable.table_name', 'notables');
    }

    protected $fillable = [
        'note',
        'notable_type',
        'notable_id',
        'creator_type',
        'creator_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function notable(): MorphTo
    {
        return $this->morphTo();
    }

    public function creator(): MorphTo
    {
        return $this->morphTo();
    }
}
