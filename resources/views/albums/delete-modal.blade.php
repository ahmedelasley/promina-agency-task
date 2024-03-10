<div class="modal fade" id="delete{{ $album->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('Delete Album') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('albums.destroy',$album->id) }}" method="POST">
                <div class="modal-body">
                    @csrf
                    @method('DELETE')
                    <p>Do you want to delete all pictures in the album or move them to another album?</p>

                    <div x-data="{ action: '' }">
                        <div class="form-group">
                            <label for="action">Action</label>
                            <select x-model="action" class="form-control" name="action" id="action">
                                <option value="">{{ __('Select Action') }}</option>
                                <option value="delete">{{ __('Delete All Pictures') }}</option>
                                <option value="move">{{ __('Move Pictures to') }}</option>
                            </select>
                        </div>
                        
                        <div x-show="action === 'move'" class="form-group" id="destinationAlbumSection">
                            <label for="destination_album_id">Destination Album</label>
                            <select class="form-control" name="destination_album_id" id="destination_album_id">
                                <option value="">Select Destination Album</option>
                                @foreach($albums->where('id', "!=", $album->id) as $album)
                                    <option value="{{ $album->id }}">{{ $album->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>                   
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('Done') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Event handler for action dropdown menu change
    $('#action').change(function() {
        var selectedAction = $(this).val();
        // If "Move Pictures to" option is selected, show the destinationAlbumSection
        if (selectedAction === 'move') {
            $('#destinationAlbumSection').show();
        } else {
            // Otherwise, hide the destinationAlbumSection
            $('#destinationAlbumSection').hide();
        }
    });
});


</script>