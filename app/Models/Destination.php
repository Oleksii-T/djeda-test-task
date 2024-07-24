<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    protected $connection = 'destinations';

    /**
     * Get destinations in radios by given coordinates
     * 
     * @param float $lat
     * @param float $lon
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getByPoint(float $lat, float $lon): \Illuminate\Database\Eloquent\Collection
    {
        // hard code radius (can be stored as const/env/requestParameter)
        $radius = 50;

        // eatch avarage radius
        $earthRadius = 6371;

        // get min/max lat/lon to make calculations faster
        $maxLat = $lat + rad2deg($radius / $earthRadius);
        $minLat = $lat - rad2deg($radius / $earthRadius);
        $maxLon = $lon + rad2deg($radius / $earthRadius / cos(deg2rad($lat)));
        $minLon = $lon - rad2deg($radius / $earthRadius / cos(deg2rad($lat)));

        // get all destinations which are within min/max bounds, add distance, filter and sort.
        return self::query()
            ->where('lat', '<', $maxLat)
            ->where('lat', '>', $minLat)
            ->where('lon', '<', $maxLon)
            ->where('lon', '>', $minLon)
            ->get()
            ->map(function ($d) use ($lat, $lon) {
                $d->distance = haversineGreatCircleDistance($lat, $lon, $d->lat, $d->lon);
                return $d;
            })
            ->filter(fn($d, $key) => $d->distance <= $radius)
            ->sortBy('distance')
            ->values();

        // we can calculate distance via SQLite, but here is some kind of a bug.
        return self::query()
            ->select('id', 'lat', 'lon', DB::raw("
                (6371 * 2 * ASIN(SQRT(
                    POWER(SIN((:lat - lat) * PI() / 180 / 2), 2) +
                    COS(:lat * PI() / 180) * COS(lat * PI() / 180) *
                    POWER(SIN((:lon - lon) * PI() / 180 / 2), 2)
                ))) AS distance
            "))
            ->whereBetween('lat', [$minLat, $maxLat])
            ->whereBetween('lon', [$minLon, $maxLon])
            ->groupBy('id', 'lat', 'lon')
            ->having('distance', '<=', $radius)
            ->orderBy('distance')
            ->setBindings([$lat, $lat, $lon])
            ->get();
    }


}
