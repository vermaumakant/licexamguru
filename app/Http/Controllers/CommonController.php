<?php

namespace App\Http\Controllers;

use App\Models\CountryMaster;
use File;
use Illuminate\Http\Request;

class CommonController extends Controller
{
    public function upload(Request $request)
    {
        $path = $request->file('file')->store('temp');
        return response()->json(['path' => $path]);
    }

    public function uploadPublic(Request $request)
    {
        $path = $request->file('file')->store('temp');
        $origin_path = storage_path('app/' . $path);
        $path = str_replace('temp/', 'quiz-images/', $path);
        if (file_exists($origin_path)) {
            $destination_path = public_path($path);
            File::move($origin_path, $destination_path);
        }
        return response()->json(['path' => url($path)]);
    }

    public function getCountries()
    {
        $countries = CountryMaster::select('name')->get();
        return response()->json(['countries' => $countries]);
    }

    public function loadIcons()
    {
        $fileList = glob(public_path('images/icons/*'));
        $icons = [];
        foreach ($fileList as $filename) {
            $icons[] = str_replace(public_path('').'/', '', $filename);
        }
        return response()->json(['icons' => $icons]);
    }
    public function uploadIcons(Request $request)
    {
        $path = $request->file('file')->store('temp');
        $origin_path = storage_path('app/' . $path);
        $path = str_replace('temp/', 'images/icons/', $path);
        if (file_exists($origin_path)) {
            $destination_path = public_path($path);
            File::move($origin_path, $destination_path);
        }
        return response()->json(['path' => url($path)]);
    }
}
