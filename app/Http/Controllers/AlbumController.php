<?php

namespace App\Http\Controllers;
use App\Http\Requests\AlbumRequest;
use App\Models\Album;
use App\Models\Picture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Storage;

class AlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $albums = Album::withCount('pictures')->latest()->paginate(10);
        return view('albums.index', compact('albums'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('albums.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\AlbumRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AlbumRequest $request)
    {
        try {
            $validated = $request->validated();
            Album::create([
                'name' => $validated['name'],
                'user_id' => Auth::user()->id,
            ]);

            Alert::success('Success', 'Added successfully');
            return redirect()->route('albums.index');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Album  $album
     * @return \Illuminate\Http\Response
     */
    public function show(Album $album)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Album  $album
     * @return \Illuminate\Http\Response
     */
    public function edit(Album $album)
    {
        return view('albums.form', ['album' => $album]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\AlbumRequest  $request
     * @param  \App\Models\Album  $album
     * @return \Illuminate\Http\Response
     */
    public function update(AlbumRequest $request, Album $album)
    {
        try {
            $validated = $request->validated();
            $album->update([
                'name' => $validated['name'],
                'user_id' => Auth::user()->id,
            ]);

            Alert::success('Success', 'Updated successfully');
            return redirect()->route('albums.index');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Album  $album
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Album $album)
    {
        // Check if the album is empty or not
        if ($album->pictures->isEmpty()) {
            // If the album is empty, simply delete it
            $album->delete();

            Alert::success('Success', 'Album deleted successfully');
            return redirect()->route('albums.index');
        }

        // If the album is not empty, show a confirmation modal
        if ($request->action === 'delete') {
            // Delete all pictures in the album
            foreach ($album->pictures as $picture) {
                $this->deletePicture($picture);
            }
            $album->delete();

            Alert::success('Success', 'Album deleted successfully');
            return redirect()->route('albums.index');
        } elseif ($request->action === 'move') {
            // Move pictures to another album
            $destinationAlbumId = $request->destination_album_id;
            if (!$destinationAlbumId) {
                return redirect()->back()->with('error', 'Please select a destination album.');
            }
            foreach ($album->pictures as $picture) {
                $picture->update(['album_id' => $destinationAlbumId]);
            }
            $album->delete();

            Alert::success('Success', 'Pictures moved to another album successfully');
            return redirect()->route('albums.index');
        } else {
            Alert::success('error', 'Invalid action.');
            return redirect()->back();
        }
    }

    private function deletePicture($picture)
    {
        // Delete picture from storage
        if (Storage::exists($picture->path)) {
            Storage::delete($picture->path);
        }
        // Delete picture record from database
        $picture->delete();
    }

}
