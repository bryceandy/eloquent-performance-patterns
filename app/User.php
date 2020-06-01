<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_trip_at' => 'datetime',
    ];

    /**
     * Define relationship to a club
     *
     * @return BelongsTo
     */
    public function club()
    {
        return $this->belongsTo(Club::class);
    }

    /**
     * Relationship between users
     *
     * @return BelongsToMany
     */
    public function buddies()
    {
        return $this
            ->belongsToMany($this, 'buddies', 'user_id', 'buddy_id')
            ->withTimestamps();
    }

    /**
     * Relationship to the users' trips
     *
     * @return HasMany
     */
    public function trips()
    {
        return $this->hasMany(Trip::class);
    }

    /**
     * Query scope to show users which a fisher can see
     *
     * @param $query
     * @param User $user
     */
    public function scopeVisibleTo($query, User $user)
    {
        $query->where(fn ($sub) => $sub
            ->where('club_id', $user->club_id)
            ->orWhereIn('id', $user->buddies->pluck('id'))
        );
    }

    public function scopeOrderByBuddiesFirst($query, User $user)
    {
        $query->orderBySub(fn ($sub) => $sub
            ->selectRaw('true')
            ->from('buddies')
            ->whereColumn('buddies.buddy_id', 'users.id')
            ->where('user_id', $user->id)
            ->limit(1)
        );
    }

    /*public function scopeWithLastTripDate($query)
    {
        $query->addSubSelect('last_trip_at', fn($sub) => $sub
            ->select('when_at')
            ->from('trips')
            ->whereColumn('user_id', 'users.id')
            ->latest('when_at')
            ->limit(1)
        );
    }

    public function scopeWithLastTripLake($query)
    {
        $query->addSubSelect('last_trip_lake', fn($sub) => $sub
            ->select('lake')
            ->from('trips')
            ->whereColumn('user_id', 'users.id')
            ->latest('when_at')
            ->limit(1)
        );
    }*/

    /**
     * Create a dynamic relationship
     *
     * @return BelongsTo
     */
    public function lastTrip()
    {
        return $this->belongsTo(Trip::class);
    }

    /**
     * Query scope for the dynamic relationship
     *
     * @param $query
     */
    public function scopeWithLastTrip($query)
    {
        $query->addSubSelect('last_trip_id', fn($sub) => $sub
            ->select('id')
            ->from('trips')
            ->whereColumn('user_id', 'users.id')
            ->latest('when_at')
            ->limit(1)
        )->with('lastTrip');
    }

    /**
     * Scope to search user by their name and or club name
     *
     * @param $query
     * @param string|null $terms
     */
    public function scopeSearch($query, string $terms)
    {
        collect(explode(' ', $terms))->filter()->each(function ($term) use ($query) {
            $term = '%'.$term.'%';

            $query->where(fn ($query) => $query
                ->where('name', 'LIKE', $term)
                ->orWhere('email', 'LIKE', $term)
                //->orWhereHas('club', fn($query) => $query->where('name', 'LIKE', $term))
                ->orWhereIn('club_id',/* fn($query) => $query
                    ->select('id')
                    ->from('clubs')
                    ->where('name', 'LIKE', $term)*/
                    Club::toBase()->where('name', 'LIKE', $term)->pluck('id')
                )
            );
        });
    }
}
