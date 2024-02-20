<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function statistics(Request $request)
    {
        $user = $request->user();

        $albums = Album::where('user_id', $user->id)
            ->get();

        $photos = Photo::whereIn('album_id', $albums->pluck('id'))
            ->take(5)
            ->get()
            ->count();

        return view(
            'dashboard',
            [
                'user' => $user,
                'countAlbum' => $albums->count(),
                'countPhoto' => $photos
            ]
        );
    }
}
