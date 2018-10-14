<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Gallery;
use App\Http\Resources\MediaResource;

class ApiUploadController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'file' => 'file',
            'name' => 'required'
        ]);

        $gallery = Gallery::firstOrCreate(['name' => 'Uploads']);

        $media = $gallery->addMediaFromRequest('file')
                         ->withCustomProperties(['name' => $request->name])
                         ->sanitizingFileName(function ($fileName) {
                            return strtolower(str_replace(['#', '/', '\\', ' '], '-', $fileName));
                         })
                         ->toMediaCollection('uploads');

        return ['data' => $media];
    }

    public function index(Request $request)
    {
        $gallery = Gallery::where(['name' => 'Uploads'])->first();

        return MediaResource::collection($gallery->media()->paginate());
    }
}
