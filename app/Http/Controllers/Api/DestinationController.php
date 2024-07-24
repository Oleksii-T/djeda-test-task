<?php

namespace App\Http\Controllers\Api;

use App\Models\Destination;
use Illuminate\Http\Request;
use App\Traits\JsonResponsable;
use App\Http\Controllers\Controller;
use App\Http\Resources\DestinationResource;
use App\Http\Requests\Api\DestinationIndexRequest;

class DestinationController extends Controller
{
    use JsonResponsable;

    public function index(DestinationIndexRequest $request)
    {
        $destinations = Destination::getByPoint($request->lat, $request->lon);

        return $this->jsonSuccess('Destinations received successfully', [
            'destinations' => DestinationResource::collection($destinations)
        ]);
    }
}
