@extends ('layout')
 
@section ('content')
 
    <h1>{{ $title }}</h1>
 
    @if (count($items) > 0)
 
        <table class="table table-sm table-hover table-striped">
            <thead class="thead-light">
                <tr>
                    <th>ID</th>
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
                        <td>{{ $album->name }}</td>
                        <td>{{ $album->artist->name }}</td>
                        <td>{{ $album->year }}</td>
                        <td>{{ number_format($album->streams, 0, '.', ',') }}</td>
                        <td>{!! $album->display ? '&#x2714;' : '&#x274C;' !!}</td>
                        <td>
                            <a href="/albums/update/{{ $album->id }}" class="btn btn-outline-primary btn-sm">Labot</a> /
                            <form method="post" action="/albums/delete/{{ $album->id }}" class="d-inline deletion-form" enctype="multipart/form-data" >
                                @csrf
                                <button type="submit" class="btn btn-outline-danger btn-sm">Dzēst</button>                 
<div class ="mb-3"> 
    <label for ="album-image" class ="form-label" >Attēls</label> 
    @if ($album->image ) 
        <img src= "{{ asset('images/' . $album->image ) }}" class ="img-fluid img-thumbnail d-block mb-2" alt= "{{ $album->name }}" > 
    @endif 
    <input type= "file" accept= "image/png, image/jpeg, image/webp" id= "album-image" name="image" class ="form-control @error('image') is-invalid @enderror" > 
    @error ( 'image' ) 
        <p class ="invalid-feedback" >{{ $errors->first ( 'image' ) }}</p> 
    @enderror 
</div>
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