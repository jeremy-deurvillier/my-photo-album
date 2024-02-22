<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Photo extends Model
{
    use HasFactory;

    /**
     * Get album for a photo.
     */
    public function albums()
    {
        return $this->belongsToMany(Album::class);
    }

    /**
     * Count all photos by user.
     */
    static public function countAllByUser(int $userId)
    {
        $albums = Album::where('user_id', $userId)->get();

        return DB::table('album_photo', 'ap')
            ->whereIn('album_id', $albums->pluck('id'))
            ->select('photo_id')
            ->distinct()
            ->get()
            ->count()
        ;
    }

    /**
     * Get a existing photo.
     */
    public function photoExists(string $hash)
    {
        return $this->where('hash', $hash)
            ->get()
            ->first();
    }

    /**
     * Indicates if a photo exists in a album.
     */
    public function photoExistsInAlbum(int $albumId)
    {
        $counter = $this->albums()
            ->where('albums.id', $albumId)
            ->get()
            ->count()
        ;

        return $counter > 0;
    }

    /**
     * Upload photo on the server.
     */
    public function saveFile(UploadedFile $file)
    {
        $path = 'public/upload-images';
        $explodeFileName = explode('.', $this->original_name);
        $extension = '.' . $explodeFileName[count($explodeFileName) - 1];

        Storage::putFileAs($path, $file, $this->hash . $extension);
    }
}
