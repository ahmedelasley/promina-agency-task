<div class="modal fade" id="show{{ $album->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('Show Album') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                <div class="modal-body">
                    <div class="d-flex justify-content-between">
                        <h6>{{ $album->user->name }}</h6>
                        <div>
                            <h4 class="modal-title text-center">{{ $album->name }}</h4>
                            <h6 class="modal-title text-center">( {{ $album->pictures_count}} ) {{ __('Pictures') }}</h6>
                        </div>
                        <h6>{{ $album->created_at() }}</h6>

                    </div>

                    <div class="row modal-body">
                        @forelse ($album->pictures as $picture)
                            <div class="col-sm-3 col-md-3 col-lg-3" >
                                <img src="{{ URL::asset($picture->path) }}" class="img-thumbnail w-100" style="height: 150px;" alt="{{ $picture->name }}">
                                <h6 class="modal-title text-center">{{ $picture->name }}</h6>
                            </div>
                        @empty

                        @endforelse
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                </div>
        </div>
    </div>
</div>