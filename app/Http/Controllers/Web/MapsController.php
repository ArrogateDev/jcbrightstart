<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

class MapsController extends Controller
{

    public function index()
    {
        $maps = storage_path('app/public/maps.json');
        $maps = json_decode(file_get_contents($maps), true);

        $types = array_values(array_unique(array_column($maps, 'Type of Child Care Centers')));
        sort($types);

        return view('web.maps', compact('types', 'maps'));
    }
}
