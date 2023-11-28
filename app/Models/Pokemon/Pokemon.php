<?php

namespace App\Models\Pokemon;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Pokemon extends Model
{
    use HasFactory;

    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'pokemon_id',
        'image'
    ];

    public function types(): BelongsToMany
    {
        return $this->belongsToMany(
            PokemonTypes::class, 'pokemons_types', 'pokemon_id'
        );
    }
}
