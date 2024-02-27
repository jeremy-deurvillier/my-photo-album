<?php

namespace App\Http\Controllers;

use App\Jobs\UploadedFileManager;
use App\Models\Album;
use App\Models\Photo;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    public function collection(Request $request)
    {
        $user = $request->user();

        $albums = Album::getMyAlbums($user->id);

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
        $filePaths = [];

        foreach ($request->file('photos') as $file) {
            $datasFile = [];

            $datasFile['path'] = $file->store('public/temp_images');
            $datasFile['original_name'] = $file->getClientOriginalName();

            $filePaths[] = $datasFile;
        };

        UploadedFileManager::dispatch($filePaths, $album);

        return redirect('/albums/' . $album->id);
    }

    public function showPhoto(Request $request, int $photoId)
    {
        $photo = Photo::find($photoId);

        return view(
            'single-photo',
            [
                'photo' => $photo
            ]
        );
    }

    public function deletePhoto(Request $request, int $albumId)
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

    public function update(Request $request, int $albumId)
    {
        $request->validateWithBag('albumUpdating', [
            'title' => ['required'],
        ]);

        $album = Album::find($albumId);

        $album->title = $request->title;
        $album->updated_at = Carbon::now();

        $album->save();

        return redirect('/albums/' . $album->id);
    }

    public function delete(Request $request, int $albumId)
    {
        $request->validateWithBag('albumDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $album = Album::find($albumId);

        $album->deleted_at = Carbon::now();

        $album->save();

        return redirect('/albums');
    }
}
