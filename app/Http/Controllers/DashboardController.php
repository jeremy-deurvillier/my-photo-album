<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function list(Request $request) {
        return view(
            'dashboard',
            [
                'user' => $request->user(),
                'albums' => Album::all()
            ]
        );
    }
}
