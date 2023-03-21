# FOD Movies
This API comes with 10 randomly generated movies and attached 2 randomly generated genres
This API uses an SQLITE database however can be configured to use any database

## Installation
- `composer install`
- `cp .env.example .env`
- `php artisan migrate:fresh && php artisan db:seed`

## Running the application
`php -S localhost:8000 -t public`

## Available endpoints
- get /api/movie
- get /api/movie/{id}
- post /api/movie
- delete /api/movie/{id}

## Documentation
Swagger OpenApi documentation
`vendor/bin/openapi app -o openapi.yml`
Documentation then found at root of directory in `openapi.yml` file


## Pitfalls and Considerations
- Documentation could have been more in-depth (Schema relationships)
- Mixture between annotations and DocBlocks
- Would be nice to attach multiple genres when creating a movie
- Only way to create genres is when creating a movie
- return messages may not be the best to inform users on their actions
- Testing should have been more in-depth
- Could integrate Swagger UI for interactive documentation
