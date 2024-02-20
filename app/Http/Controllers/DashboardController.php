<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Photo;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function albumCollection(Request $request)
    {
        $user = $request->user();
        $albums = Album::where('user_id', $user->id)->get();
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

        return view(
            'single-album',
            [
                'user' => $user,
                'album' => $album
            ]
        );
    }
}
