@extends('layout')

@section('content')

<h1>{{ $title }}</h1>

@if ($errors->any())
    <div class="alert alert-danger">Lūdzu, novērsiet radušās kļūdas!</div>
@endif

<form
    method="post"
    action="{{ $album->exists ? '/albums/patch/' . $album->id : '/albums/put' }}"
    enctype="multipart/form-data">
    @csrf
    @if ($album->exists)
        @method('PATCH')
    @endif

    <div class="mb-3">
        <label for="album-name" class="form-label">Nosaukums</label>
        <input
            type="text"
            id="album-name"
            name="name"
            value="{{ old('name', $album->name) }}"
            class="form-control @error('name') is-invalid @enderror"
        >
        @error('name')
            <p class="invalid-feedback">{{ $errors->first('name') }}</p>
        @enderror
    </div>

    <div class="mb-3">
        <label for="album-artist" class="form-label">Autors</label>
        <select
            id="album-artist"
            name="artist_id"
            class="form-select @error('artist_id') is-invalid @enderror"
        >
            <option value="">Norādiet mūziķi!</option>
            @foreach ($artists as $artist)
                <option
                    value="{{ $artist->id }}"
                    @if ($artist->id == old('artist_id', $album->artist->id ?? null)) selected @endif
                >{{ $artist->name }}</option>
            @endforeach
        </select>
        @error('artist_id')
            <p class="invalid-feedback">{{ $errors->first('artist_id') }}</p>
        @enderror
    </div>

   <div class="mb-3">
        <label for="album-genre" class="form-label">Žanrs</label>
        <select
            id="album-genre"
            name="genre_id"
            class="form-select @error('genre_id') is-invalid @enderror"
        >
            <option value="">Norādiet žanru!</option>
            @foreach ($genres as $genre)
                <option
                    value="{{ $genre->id }}"
                    @if ($genre->id == old('genre_id', $album->genre_id ?? null)) selected @endif
                >{{ $genre->name }}</option>
            @endforeach
        </select>
        @error('genre_id')
            <p class="invalid-feedback">{{ $errors->first('genre_id') }}</p>
        @enderror
    </div>

    <div class="mb-3">
        <label for="album-year" class="form-label">Izdošanas gads</label>
        <input
            type="number" min="1900" max="{{ date('Y') + 1 }}" step="1"
            id="album-year"
            name="year"
            value="{{ old('year', $album->year) }}"
            class="form-control @error('year') is-invalid @enderror"
        >
        @error('year')
            <p class="invalid-feedback">{{ $errors->first('year') }}</p>
        @enderror
    </div>

    <div class="mb-3">
        <label for="album-streams" class="form-label">Albuma atskaņojumi</label>
        <input
            type="number" min="0" step="1"
            id="album-streams"
            name="streams"
            value="{{ old('streams', $album->streams) }}"
            class="form-control @error('streams') is-invalid @enderror"
        >
        @error('streams')
            <p class="invalid-feedback">{{ $errors->first('streams') }}</p>
        @enderror
    </div>

    <div class="mb-3">
        <label for="album-image" class="form-label">Attēls</label>
        @if ($album->image)
            <img src="{{ asset('images/' . $album->image) }}" class="img-fluid img-thumbnail d-block mb-2" alt="{{ $album->name }}">
        @endif
        <input type="file" accept="image/png, image/jpeg, image/webp" id="album-image" name="image" class="form-control @error('image') is-invalid @enderror">
        @error('image')
            <p class="invalid-feedback">{{ $errors->first('image') }}</p>
        @enderror
    </div>

    <div class="mb-3">
        <div class="form-check">
            <input
                type="checkbox"
                id="album-display"
                name="display"
                value="1"
                class="form-check-input @error('display') is-invalid @enderror"
                @if (old('display', $album->display)) checked @endif
            >
            <label class="form-check-label" for="album-display">
                Publicēt ierakstu
            </label>
            @error('display')
                <p class="invalid-feedback">{{ $errors->first('display') }}</p>
            @enderror
        </div>
    </div>

    <button type="submit" class="btn btn-primary">
        {{ $album->exists ? 'Atjaunot ierakstu' : 'Pievienot ierakstu' }}
    </button>
</form>

@endsection