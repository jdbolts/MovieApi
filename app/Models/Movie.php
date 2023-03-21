<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use OpenApi\Attributes as OA;

#[OA\Schema(schema: "MovieSchema")]
class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'released',
        'description',
    ];

    #[OA\Property(property: "id", description: "The id of the movie", type: "integer")]
    private int $id;

    #[OA\Property(property: "title", description: "The title of the movie", type: "string")]
    public string $title;

    #[OA\Property(property: "released", description: "The year the movie was released", type: "integer")]
    public int $released;

    #[OA\Property(property: "description", description: "The description of the movie", type: "string")]
    public string $description;

    #[OA\Property(
        property: "genres",
        description: "The genres of the movie",
        type: "array",
        items: new OA\Items(ref: "#/components/schemas/GenreSchema"),
    )]
    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class);
    }
}
