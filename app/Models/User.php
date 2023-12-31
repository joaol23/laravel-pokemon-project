<?php

namespace App\Models;

use App\Enum\RolesUser;
use App\Models\Pokemon\Pokemon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'role',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
    ];

    public function getDeletedAtColumn(): string
    {
        return 'inactived_at';
    }

    public function isAdmin(): bool
    {
        return (int)$this->role === RolesUser::ADMIN->value;
    }

    public function pokemons(): BelongsToMany
    {
        return $this->belongsToMany(
            Pokemon::class,
            'users_pokemons',
            'user_id',
            'pokemon_id'
        )->withPivot('order')->orderByPivot('order');
    }
}
