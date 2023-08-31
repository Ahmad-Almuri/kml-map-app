<?php

// app/Http/Controllers/MapController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use SimpleXMLElement;

class MapController extends Controller
{
    public function showUploadForm()
    {
        return view('upload');
    }

    public function upload(Request $request)
    {
        $validatedData = $request->validate([
            'kmlFile' => 'required|mimes:xml',
        ]);

        $file = $request->file('kmlFile');
        $filePath = $file->storeAs('kml', $file->getClientOriginalName());

        return redirect()->route('map', ['filePath' => $filePath]);
    }

    public function displayMap(Request $request)
    {
        $filePath = $request->input('filePath');
        $kmlContents = Storage::get($filePath);

        // Parse the KML file
        $xml = new SimpleXMLElement($kmlContents);

        return view('map', ['xml' => $xml]);
    }
}

