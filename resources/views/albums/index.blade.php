@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Albums') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="section_content content_view">
                        <div class="up_element mb-2">
                            <a href="{{ route('albums.create') }}" class="btn btn-primary btn-sm">Add New Album</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover text-center">
                                <thead class="table-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>No. Pictures</th>
                                        <th>Created By</th>
                                        <th>Created Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($albums as $album)
                
                                    <tr>
                                        <th>{{ $albums->firstItem()+$loop->index }}</th>
                                        <td>{{ $album->name }}</td>
                                        <td>{{ $album->pictures_count }}</td>
                                        <td>{{ $album->user->name }}</td>
                                        <td>{{ $album->created_at() }}</td>
                                        <td>
                                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#pictures{{ $album->id }}">Add Pictues</button>
                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#show{{ $album->id }}">Show</button>

                                            <a href="{{ route('albums.edit', $album->id ) }}" class="btn btn-success btn-sm">edit</a>
                                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#delete{{ $album->id }}">Delete</button>
                
                                            @include('albums.pictures-modal',['album'=>$album])
                                            @include('albums.show-modal',['album'=>$album])
                                            @include('albums.delete-modal',['album'=>$album])
                                        </td>
                                    </tr>
                                    @empty

                                    @endforelse                
                                </tbody>
                            </table>
                            {{ $albums->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    Dropzone.options.dropzone =
    {
        maxFilesize: 12,
        renameFile: function(file) {
            var dt = new Date();
            var time = dt.getTime();
            return time+file.name;
        },
        acceptedFiles: ".jpeg,.jpg,.png,.gif",
        addRemoveLinks: true,
        timeout: 5000,
        success: function(file, response) {
            console.log(response);
        },
        error: function(file, response){
            return false;
        }
    };
</script>
@endsection
