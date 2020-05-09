<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Trip extends Model
{
    /**
     * Attributes that can not be mass-assigned
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Attributes that should be casted to a specific dataType
     * when retrieving their object in an array
     *
     * @var array
     */
    protected $casts = [
        'when_at' => 'datetime',
    ];

    /**
     * Relationship to a user
     *
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
