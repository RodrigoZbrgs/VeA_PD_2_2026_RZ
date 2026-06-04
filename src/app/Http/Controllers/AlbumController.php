<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use App\Models\Album;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;

class AlbumController extends Controller implements HasMiddleware
{
    // call auth middleware 
    public static function middleware(): array
    {
        return [
            'auth',
        ];
    }

    public function list(): View
    {
        $items = Album::orderBy('name', 'asc')->get();

        return view(
            'album.list',
            [
                'title' => 'Albumi',
                'items' => $items
            ]
        );
    }

    public function create(): View
    {
        $artists = Artist::orderBy('name', 'asc')->get();

        return view(
            'album.form',
            [
                'title' => 'Pievienot albumu',
                'album' => new Album(),
                'artists' => $artists,
            ]
        );
    }

    public function put(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|min:3|max:256',
            'artist_id' => 'required',
            'streams' => 'nullable|numeric',
            'year' => 'numeric',
            'image' => 'nullable|image',
            'display' => 'nullable',
        ]);

        $album = new Album();
        $album->name = $validatedData['name'];
        $album->artist_id = $validatedData['artist_id'];
        $album->streams = $validatedData['streams'];
        $album->year = $validatedData['year'];
        $album->display = (bool) ($validatedData['display'] ?? false);
        $album->save();

        return redirect('/albums');
    }
    public function update(Album $album): View
    {
        $artists = Artist::orderBy('name', 'asc')->get();

        return view(
            'album.form',
            [
                'title' => 'Rediģēt albumu',
                'album' => $album,
                'artists' => $artists,
            ]
        );
    }

    // update Book data 
    public function patch(Album $album, Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|min:3|max:256',
            'artist_id' => 'required',
            'streams' => 'nullable|numeric',
            'year' => 'numeric',
            'image' => 'nullable|image',
            'display' => 'nullable',
        ]);

        $album->name = $validatedData['name'];
        $album->artist_id = $validatedData['artist_id'];
        $album->streams = $validatedData['streams'];
        $album->year = $validatedData['year'];
        $album->display = (bool) ($validatedData['display'] ?? false);
        if ($request->hasFile('image')) {
            // šeit varat pievienot kodu, kas nodzēš veco bildi, ja pievieno jaunu 
            $uploadedFile = $request->file('image');
            $extension = $uploadedFile->clientExtension();
            $name = uniqid();
            $album->image = $uploadedFile->storePubliclyAs('/', $name . '.' . $extension, 'uploads');
        }
        $album->save();

        return redirect('/albums/update/' . $album->id);
    }

    public function delete(Album $album): RedirectResponse
    {
        if ($album->image) {
            unlink(getcwd() . '/images/' . $album->image);
        }
        $album->delete();
        return redirect('/albums');
    }
}