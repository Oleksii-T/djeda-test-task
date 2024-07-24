<?php

namespace App\Http\Controllers\Api;

use App\Models\Destination;
use Illuminate\Http\Request;
use App\Traits\JsonResponsable;
use App\Http\Controllers\Controller;

class DestinationController extends Controller
{
    use JsonResponsable;

    public function index(Request $request)
    {
        $destinations = Destination::first();

        return $this->jsonSuccess('Destinations received successfully', [
            'destinations' => $destinations
        ]);
    }
}
