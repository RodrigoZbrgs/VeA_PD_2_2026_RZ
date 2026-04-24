<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ArtistController extends Controller
{
    // display all Artists
    public function list(): View
    {
        $items = Artist::orderBy('name', 'asc')->get();

        return view(
            'artist.list',
            [
                'title' => 'Artists',
                'items' => $items,
            ]
        );
    }
}
