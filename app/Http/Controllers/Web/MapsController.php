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

//        $maps->map(function ($map) {
//            $map->type_text = Str::slug($map->type);
//        });
        $types = $maps->groupBy('type');
//
////        $types = $maps->pluck('type')->unique()->sort()->toArray();
//        print_r($maps->toArray());
//        die;
//        $maps = storage_path('app/public/maps.json');
//        $maps = json_decode(file_get_contents($maps), true);
//
//        $types = array_values(array_unique(array_column($maps, 'Type of Child Care Centers')));
//        sort($types);

        return view('web.maps', compact('types', 'maps'));
    }
}
