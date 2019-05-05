<?php

namespace GorillaDash\LaravelWebsite\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use mastani\GoogleStaticMap\Format;
use mastani\GoogleStaticMap\GoogleStaticMap;
use mastani\GoogleStaticMap\MapType;
use mastani\GoogleStaticMap\Size;

/**
 * Class StaticMapController
 *
 * @package GorillaDash\LaravelWebsite\Http\Controllers
 */
class StaticMapController extends Controller
{
    /**
     * @param                          $lat
     * @param                          $lng
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function map($lat, $lng, Request $request)
    {
        $width = $request->query('w', 400);
        $height = $request->query('h', 300);
        $scale = $request->query('s', 1);
        $zoom = $request->query('z', 15);
        $path = "maps/{$lat}.{$lng}.{$width}.{$height}.png";
        $disk = config('gorilladash.storage.google_map');
        if (Storage::disk($disk)->exists($path)) {
            return response(Storage::disk($disk)->get($path), 201)
                ->header('Content-Type', 'image/png');
        }

        $map = new GoogleStaticMap(config('gorilladash.credentials.google_map_key'));
        $url = $map->setCenterLatLng($lat, $lng)
            ->setMapType(MapType::RoadMap)
            ->setZoom($zoom)
            ->setScale($scale)
            ->setSize($width, $height)
            ->setFormat(Format::PNG)
            ->addMarkerLatLng($lat, $lng, '', 'red', Size::Large)
            ->make();

        $content = file_get_contents($url);
        Storage::disk($disk)->put($path, $content);

        return $this->map($lat, $lng, $request);
    }
}
