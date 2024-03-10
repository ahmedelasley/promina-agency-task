@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ isset($album) ? __('Edit Album') :__('Add New Album')  }} </div>

                <div class="card-body">
        <div class="content_view">
            <form action="{{ isset($album) ? route('albums.update', $album->id) : route('albums.store')  }}" method="POST" enctype="multipart/form-data" autocomplete="off">
                <div class="row row-gap-24">
                    @csrf
                    @isset($album)
                        @method('put')
                    @endisset
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <label for="" class="small-label">{{ __('Name Album') }} <span class="text-danger">*</span></label>
                        <input type="text"  name="name" class="form-control" value="{{ isset($album) ? old('name', $album->name) : old('name') }}">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                        
                    </div>
                    <div class="col-12 d-flex align-items-center justify-content-center mt-3">
                        <button type="submit" class="btn btn-success">{{ __('Save') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
</div>
</div>
@endsection