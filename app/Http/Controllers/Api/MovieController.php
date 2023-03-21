<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use OpenApi\Attributes as OA;

#[OA\Info(version: "0.1", title: "FOD Movies")]
class MovieController extends Controller
{
    #[OA\Get(
        path: '/api/movie',
        parameters: [
            new OA\QueryParameter(
                name: 'released',
                description: 'The date the movie was released',
                example: 1992,
            ),
            new OA\QueryParameter(
                name: 'genre',
                description: 'The genre of the movie',
                example: "Comedy",
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'OK',
                content: new OA\JsonContent(
                    type: "array",
                    items: new OA\Items(ref: "#/components/schemas/MovieSchema")
                ),
            ),
            new OA\Response(response: 401, description: 'Not allowed'),
        ]
    )]
    public function list(Request $request): string
    {
        $movies = Movie::with(['genres']);

        if($request->has('released')) {
            $movies->where('released', '=', $request->released);
        }

        if($request->has('genre')) {
            $movies->whereHas('genre', function($q) use ($request) {
                $q->where('name', $request->genre);
            });
        }

        return $movies
            ->get()
            ->toJson();
    }

    #[OA\Get(
        path: '/api/movie/{id}',
        responses: [
            new OA\Response(
                response: 200,
                description: 'OK',
                content: new OA\JsonContent(ref: "#/components/schemas/MovieSchema", type: "object"),
            ),
            new OA\Response(response: 401, description: 'Not allowed'),
            new OA\Response(response: 404, description: 'Not found'),
        ]
    )]
    public function get(string $id): string
    {
        return Movie::with('genres')->findOrFail($id)->toJson();
    }

    /**
     * @throws ValidationException
     */
    #[OA\Post(
        path: '/api/movie',
        parameters: [
            new OA\QueryParameter(
                name: 'released',
                description: 'The date the movie was released',
                example: 1992,
            ),
            new OA\QueryParameter(
                name: 'genre',
                description: 'The genre of the movie',
                example: "Drama",
            ),
            new OA\QueryParameter(
                name: 'title',
                description: 'The title of the movie',
                example: "Catch me if you can",
            ),
            new OA\QueryParameter(
                name: 'description',
                description: 'The description of the movie',
                example: "This movie is great",
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'OK',
                content: new OA\JsonContent(ref: "#/components/schemas/MovieSchema", type: "object"),
            ),
            new OA\Response(response: 401, description: 'Not allowed'),
            new OA\Response(response: 404, description: 'Not found'),
        ]
    )]
    public function create(Request $request): Movie
    {
        $genre =  Genre::firstOrCreate([
            'name' => $request->genre,
            'description' => $request->genre
        ]);

        $this->validate($request, [
            'title' => 'required',
            'released' => 'required',
            'description' => 'required',
        ]);

        $movie = Movie::create($request->all());
        $movie->genres()->sync($genre);

        return $movie->load('genres');
    }

    #[OA\Delete(
        path: '/api/movie/{id}',
        responses: [
            new OA\Response(
                response: 200,
                description: 'OK',
                content: new OA\JsonContent(ref: "#/components/schemas/MovieSchema", type: "object"),
            ),
            new OA\Response(response: 401, description: 'Not allowed'),
            new OA\Response(response: 404, description: 'Not found'),
        ]
    )]
    public function delete(string $id): Movie
    {
        $movie = Movie::findOrFail($id);
        $movie->delete();

        return $movie->load('genres');
    }
}
