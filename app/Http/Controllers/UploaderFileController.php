<?php

namespace App\Http\Controllers;

use App\Jobs\UploadedFileManager;
use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UploaderFileController extends Controller
{
    public function show(Request $request, int $albumId)
    {
        $album = Album::findOrFail($albumId);

        if ($album->deleted_at !== null) {
            abort(404);
        }

        return view(
            'uploader',
            [
                'album' => $album,
            ]
        );
    }

    public function addPhotos(Request $request, int $albumId)
    {
        // $request->validateWithBag($request->file('photos'), [
        //     'photos' => [
        //         'required',
        //         'array',
        //         'mimes:jpeg,jpg,png,gif,bmp,webp,svg,x-icon'
        //     ],
        // ]);
        $validator = Validator::make($request->file('photos'), [
            'photos' => [
                'required',
                'array',
                // 'mimes:jpeg,jpg,png,gif,bmp,webp,svg,x-icon'
            ],
        ]);

        // if ($validator->fails()) {
        //     return response()->json(['not valid']);
        // }

        $album = Album::find($albumId);
        $filePaths = [];

        foreach ($request->file('photos') as $file) {
            $datasFile = [];

            $datasFile['path'] = $file->store('public/temp_images');
            $datasFile['original_name'] = $file->getClientOriginalName();

            $filePaths[] = $datasFile;
        };

        UploadedFileManager::dispatch($filePaths, $album);

        return response()->json('ok');
    }
}
