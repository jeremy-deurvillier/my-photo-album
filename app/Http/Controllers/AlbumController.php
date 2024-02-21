<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Photo;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    public function collection(Request $request)
    {
        $user = $request->user();

        $albums = Album::where('user_id', $user->id)
            ->get()
            ->sortBy([['created_at', 'desc']]);

        return view(
            'albums',
            [
                'user' => $user,
                'albums' => $albums,
            ]
        );
    }

    public function create(Request $request)
    {
        $request->validateWithBag('albumCreation', [
            'title' => ['required'],
        ]);

        $user = $request->user();
        $albumName = $request->title;
        $album = new Album();

        $album->title = $albumName;
        $album->user_id = $user->id;
        $album->save();

        $album = $album->refresh();

        return redirect('/albums/' . $album->id);
    }

    public function single(Request $request, int $albumId)
    {
        $user = $request->user();
        $album = Album::find($albumId);
        $photos = $album->photos()
            ->get()
            ->sortBy([['created_at', 'desc']]);

        return view(
            'single-album',
            [
                'user' => $user,
                'album' => $album,
                'photos' => $photos
            ]
        );
    }

    public function addPhotos(Request $request, int $albumId)
    {
        $request->validateWithBag('photoAdd', [
            'photos' => ['required'],
        ]);

        $album = Album::find($albumId);

        foreach ($request->file('photos') as $file) {
            $photo = new Photo();
            $hashFile = hash_file('sha256', $file);
            $originalFileName = $file->getClientOriginalName();
            $existingPhoto = $photo->photoExists($hashFile);

            if (isset($existingPhoto)) {
                if (!$existingPhoto->photoExistsInAlbum($album->id)) {
                    $existingPhoto->albums()->attach($album->id);
                    $existingPhoto->albums()
                        ->updateExistingPivot($album->id, ['created_at' => Carbon::now()])
                    ;
                }
            } else {
                $photo->original_name = substr($originalFileName, 0, 255);
                $photo->hash = $hashFile;

                $photo->saveFile($file);
                $photo->save();

                $photo = $photo->refresh();

                $photo->albums()->attach($album->id);
                $photo->albums()
                    ->updateExistingPivot($album->id, ['created_at' => Carbon::now()])
                ;
            }
        }

        return redirect('/albums/' . $album->id);
    }
}
