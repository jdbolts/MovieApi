<?php

namespace Tests;

use App\Models\Movie;

class MovieControllerTest extends TestCase
{
    public function test_create_movie_successful()
    {
        $this->post('/api/movie/', [
            'title' => 'testy',
            'released' => 1992,
            'genre' => 'comedy',
            'description' => 'this is great'
        ]);

        $this->assertResponseOk();
    }

    public function test_get_movie_successful()
    {
        $this->get('/api/movie/' . Movie::first()->id);

        $this->assertResponseOk();
    }

    public function test_get_all_movies_successful()
    {
        $this->get('/api/movie');

        $this->assertResponseOk();
    }

    public function test_delete_movie_successful()
    {
        $this->delete('/api/movie/' . Movie::first()->id);

        $this->assertResponseOk();
    }
}
