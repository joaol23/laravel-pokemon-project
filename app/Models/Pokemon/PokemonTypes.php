<?php

namespace App\Models\Pokemon;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PokemonTypes extends Model
{
    use HasFactory;

    public $timestamps = false;
    public static array $colorsTypes = [
        "normal" => "white",
        "fire" => "red",
        "water" => "blue",
        "grass" => "green",
        "electric" => "yellow",
        "ice" => "lightblue",
        "fighting" => "brown",
        "poison" => "purple",
        "ground" => "orange",
        "flying" => "lightgrey",
        "psychic" => "pink",
        "bug" => "lime",
        "rock" => "darkgrey",
        "ghost" => "black",
        "dark" => "darkred",
        "dragon" => "darkblue",
        "steel" => "grey",
        "fairy" => "lightpink"
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'color'
    ];
}
