<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function albumCollection(Request $request)
    {
        $user = $request->user();

        $albums = Album::where('user_id', $user->id)
            ->get()
            ->sortBy([['created_at', 'desc']]);

        $photos = Photo::whereIn('album_id', $albums->pluck('id'))
            ->take(5)
            ->get()
            ->sortBy([['created_at', 'desc']]);

        return view(
            'dashboard',
            [
                'user' => $user,
                'albums' => $albums,
                'photos' => $photos
            ]
        );
    }

    public function createAlbum(Request $request)
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

        return redirect('/dashboard/' . $album->id);
    }

    public function album(Request $request, int $albumId)
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

        $user = $request->user();
        $album = Album::find($albumId);

        foreach ($request->file('photos') as $file) {
            $photo = new Photo();
            $path = 'public/upload-images';
            $originalFileName = $file->getClientOriginalName();

            $photo->name = (strlen($originalFileName) > 40) 
                ? substr($originalFileName, 0, 40) 
                : $originalFileName;

            $photo->album_id = $album->id;
            $photo->hash = hash_file('sha256', $file);

            Storage::putFileAs($path, $file, $photo->name);

            if (Storage::exists($path . '/' . $photo->name)) {
                $photo->save();
            }
        }

        $album = $album->refresh();
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
}
