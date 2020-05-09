<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Club extends Model
{
    /**
     * Attributes that may not be mass-assigned
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Define relationship to a user
     *
     * @return HasMany
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
