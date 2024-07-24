# Djeda test task
Simple Destinations API

### Installation

Install dependencies

```sh
composer install
```

Set up the server in any way you like. 
Sail can be used as well.

```sh
php artisan sail:install
./vendor/bin/sail up -d
```

Put the database source file 'destinations.sqlite' into the database folder
Done, the endpoint /api/destinations can be used to query the destinations by coorinates.

## Example usage

```sh
curl --location 'http://localhost/api/destinations?lat=45.3502006530762&lon=11.7826995849609' \
--header 'Accept: application/json' \
--header 'Content-Type: application/json'
```

## TODO

1. set up OpenAPI documentation for the endpoint.
2. Calculate the distance in SQLite to optimize response time.
3. improve testing.
4. Set up caching.
