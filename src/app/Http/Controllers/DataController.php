<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\JsonResponse;

class DataController extends Controller
{
    // Return 3 published Albums in random order
    public function getTopAlbums(): JsonResponse
    {
        $albums = Album::where('display', true)
            ->with('genre', 'artist')
            ->inRandomOrder()
            ->take(3)
            ->get();

        return response()->json($albums->map->jsonSerialize()->values());
    }

    // Return selected Album if it's published
    public function getAlbum(Album $album): JsonResponse
    {
        $selectedAlbum = Album::where([
            'id' => $album->id,
            'display' => true,
        ])
            ->with('genre', 'artist')
            ->firstOrFail();

        return response()->json($selectedAlbum->jsonSerialize());
    }

    // Return 3 published Albums in random order- except the selected Album
    public function getRelatedAlbums(Album $album): JsonResponse
    {
        $albums = Album::where('display', true)
            ->where('id', '<>', $album->id)
            ->with('genre', 'artist')
            ->inRandomOrder()
            ->take(3)
            ->get();

        return response()->json($albums->map->jsonSerialize()->values());
    }
}
