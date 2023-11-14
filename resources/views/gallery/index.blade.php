@extends('auth.layouts')
@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Photos</div>
            <div class="card-body">
                <div class="row">
                    @if(count($galleries)>0)
                    @foreach ($galleries as $gallery)
                    <div class="col-sm-2">
                        <div>
                            <a class="example-image-link" href="{{$gallery->original_pict}}" data-lightbox="roadtrip" data-title="{{$gallery->description}}">
                                <img class="example-image img-fluid mb-2" src="{{asset('storage/posts_image/'.$gallery->picture )}}" alt="image-1" />
                            </a>
                            <div class="mt-2">
                                <a href="{{ route('gallery.edit', $gallery->id) }}" class="btn btn-warning">Edit</a>
                                <form action="{{ route('gallery.destroy', $gallery->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this photo?')">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @else
                    <h3>Tidak ada data.</h3>
                    @endif
                    <div class="d-flex">
                        {{ $galleries->links() }}
                    </div>
                </div>
                <div class="text-end mt-3">
                    <a href="{{ route('gallery.create') }}" class="btn btn-primary">Upload Photo</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

