<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\View\View;

class GenreController extends Controller implements HasMiddleware
{
    public function list(): View
    {
        $items = Genre::orderBy('name', 'asc')->get();

        return view(
            'genre.list',
            [
                'title' => 'Genres',
                'items' => $items,
            ]
        );
    }

    // display new genres form
    public function create(): View
    {
        return view(
            'genre.form',
            [
                'title' => 'Izveidot genre',
                'genre' => new genre()
            ]
        );
    }

    // create new Genre
    public function put(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $genre = new Genre();
        $genre->name = $validatedData['name'];
        $genre->save();

        return redirect('/genres');
    }

    // display Genre editing form
    public function update(Genre $genre): View
    {
        return view(
            'genre.form',
            [
                'title' => 'Rediģēt genre',
                'genre' => $genre
            ]
        );
    }

    // update existing Author data
    public function patch(Genre $genre, Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $genre->name = $validatedData['name'];
        $genre->save();

        return redirect('/genres');
    }

    public function delete(Genre $genre): RedirectResponse
    {
        // šeit derētu pārbaude, kas neļauj dzēst autoru, ja tas piesaistīts eksistējošām grāmatām
        $genre->delete();
        return redirect('/genres');
    }

    public static function middleware(): array
    {
        return [
            'auth',
        ];
    }
}
