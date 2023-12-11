<?php

namespace App\Models\Pokemon;

use Database\Factories\PokemonFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\Factory;
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

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['types'];

    public function types(): BelongsToMany
    {
        return $this->belongsToMany(
            PokemonTypes::class,
            'pokemons_types_pokemon',
            'pokemon_id'
        );
    }
    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): Factory
    {
        return PokemonFactory::new();
    }
}
