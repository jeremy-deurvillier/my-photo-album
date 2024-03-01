<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Photo;
use Illuminate\Http\Request;

class PhotoController extends Controller
{
    public function show(Request $request, int $photoId)
    {
        $photo = Photo::findOrFail($photoId);

        return view(
            'single-photo',
            [
                'photo' => $photo
            ]
        );
    }

    public function delete(Request $request, int $albumId)
    {
        $request->validateWithBag('photoDeletion', [
            'photo' => ['required'],
        ]);

        $album = Album::find($albumId);
        $photo = Photo::find($request->photo);

        $album->photos()->detach($photo->id);

        $count = $photo->inAnotherAlbum();

        if ($count === 0) {
            $photo->deleteFile();
            Photo::destroy($photo->id);
        }

        return redirect('/albums/' . $album->id);
    }
}
