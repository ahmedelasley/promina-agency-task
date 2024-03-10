<div class="modal fade" id="pictures{{ $album->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('Upload multiple Pictures') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('pictures.store') }}" method="POST" enctype="multipart/form-data" class="dropzone" id="dropzone">
                    @csrf
                    <input type="hidden" name="album_id" value="{{ $album->id }}">

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
            </div>
           
        </div>
    </div>
</div>