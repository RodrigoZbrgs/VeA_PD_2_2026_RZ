@extends ('layout')

@section ('content')

    <h1>{{ $title }}</h1>

    @if (count($items) > 0)

        <table class="table table-sm table-hover table-striped">
            <thead class="thead-light">
                <tr>
                    <th>ID</th>
                    <th>Attēls</th>
                    <th>Nosaukums</th>
                    <th>Autors</th>
                    <th>Gads</th>
                    <th>Albuma atskaņojumi</th>
                    <th>Attēlot</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($items as $album)
                    <tr>
                        <td>{{ $album->id }}</td>
                        <td>
                            @if ($album->image)
                                <img src="{{ asset('images/' . $album->image) }}" class="img-fluid img-thumbnail"
                                    alt="{{ $album->name }}" style="max-width: 60px;">
                            @endif
                        </td>
                        <td>{{ $album->name }}</td>
                        <td>{{ $album->artist->name }}</td>
                        <td>{{ $album->year }}</td>
                        <td>{{ number_format($album->streams, 0, '.', ',') }}</td>
                        <td>{!! $album->display ? '&#x2714;' : '&#x274C;' !!}</td>
                        <td>
                            <a href="/albums/update/{{ $album->id }}" class="btn btn-outline-primary btn-sm">Labot</a> /
                            <form method="post" action="/albums/delete/{{ $album->id }}" class="d-inline deletion-form">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger btn-sm">Dzēst</button>
                            </form>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>

    @else
        <p>Nav atrasts neviens ieraksts</p>
    @endif

    <a href="/albums/create" class="btn btn-primary">Pievienot jaunu</a>

@endsection