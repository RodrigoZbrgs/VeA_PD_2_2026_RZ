<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ArtistController extends Controller implements HasMiddleware
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

    // display new artists form
    public function create(): View
    {
        return view(
            'artist.form',
            [
                'title' => 'Rediģēt artist',
                'artist' => new artist()
            ]
        );
    }

    // create new Artist
    public function put(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $artist = new Artist();
        $artist->name = $validatedData['name'];
        $artist->save();

        return redirect('/artists');
    }

    // display Artist editing form
    public function update(Artist $artist): View
    {
        return view(
            'artist.form',
            [
                'title' => 'Rediģēt artist',
                'artist' => $artist
            ]
        );
    }

    // update existing Author data
    public function patch(Artist $artist, Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $artist->name = $validatedData['name'];
        $artist->save();

        return redirect('/artists');
    }

    public function delete(Artist $artist): RedirectResponse
    {
        // šeit derētu pārbaude, kas neļauj dzēst autoru, ja tas piesaistīts eksistējošām grāmatām
        $artist->delete();
        return redirect('/artists');
    }

    public static function middleware(): array
{
    return [
        'auth',
    ];
}
}
