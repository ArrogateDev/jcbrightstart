<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\ServiceLocation;
use Illuminate\Support\Str;

class MapsController extends Controller
{

    public function index()
    {
        $maps = ServiceLocation::query()
            ->select('id', 'type', 'age', 'district', 'capacity', 'organization', 'address', 'phone', 'email', 'webpage', 'service_hour', 'longitude', 'latitude')
            ->get();

        $types = $maps->groupBy('type');

        return view('web.maps', compact('types', 'maps'));
    }

    public function list()
    {
        $maps = ServiceLocation::query()
            ->select('id', 'type', 'age', 'district', 'capacity', 'organization', 'address', 'phone', 'email', 'webpage', 'service_hour', 'longitude', 'latitude')
            ->get();

        $types = $maps->groupBy('type');

        return view('web.maps-list', compact('types', 'maps'));
    }
}
