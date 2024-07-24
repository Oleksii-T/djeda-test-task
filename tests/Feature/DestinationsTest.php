<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DestinationsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        //TODO: set up test data and pre-define test cases
    }

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_destinations(): void
    {
        $fromLat = 45.3502006530762;
        $fromLon = 11.7826995849609;
        $radius = 50;
        $response = $this->call('GET', '/api/destinations', [
            'lat' => $fromLat,
            'lon' => $fromLon
        ]);

        $response->assertStatus(200);

        $destinations = $response->json()['data']['destinations'];

        $prevDistance = 0;
        foreach ($destinations as $destination) {
            // recalculate distance
            $distance = haversineGreatCircleDistance($fromLat, $fromLon, $destination['lat'], $destination['lon']);

            // validate distance form response
            $this->assertEquals($destination['distance'], $distance);

            // validate sorting
            $this->assertGreaterThanOrEqual($prevDistance, $destination['distance']);

            // validate distance is within giver radius
            $this->assertGreaterThan($destination['distance'], $radius);

            // remember previous radius
            $prevDistance = $destination['distance'];
        }

        //TODO: test that there is not suitable results are left in the DB
    }
}
