<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function list(Request $request) {
        $user = $request->user();

        return view(
            'dashboard',
            [
                'user' => $user,
                'albums' => Album::where('user_id', $user->id)->get()
            ]
        );
    }
}
