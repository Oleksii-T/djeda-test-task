# Djeda test task
Simple Destinations API

### Installation

Install dependancies

```sh
composer install
```

Set up server in any way you like. 
Sail can be used as well.

```sh
php artisan sail:install
./vendor/bin/sail up -d
```

Put the database source file 'destinations.sqlite' to the database folder
Done, the endpoint /api/destinations can be used to query the destinations by coorinates.

## TODO

1. set up OpenAPI documentation for endpoint.
2. Calculate distance in SQLite to optimize response time.
3. improve testing.
4. Set up caching.
