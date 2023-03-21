<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use OpenApi\Attributes as OA;

#[OA\Schema(schema: "GenreSchema")]
class Genre extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    #[OA\Property(property: "id", description: "The id of the genre", type: "integer")]
    private int $id;

    #[OA\Property(property: "name", description: "The name of the genre", type: "string")]
    public string $name;

    #[OA\Property(property: "description", description: "The description of the genre", type: "string")]
    public string $description;

    #[OA\Property(
        property: "movies",
        description: "The movies of the genre",
        type: "array",
        items: new OA\Items(ref: "#/components/schemas/MovieSchema"),
    )]
    public function movies(): BelongsToMany
    {
        return $this->belongsToMany(Movie::class);
    }
}
