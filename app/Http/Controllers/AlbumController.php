<?php

namespace App\Http\Controllers;

use App\Traits\Media;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Models\Picture;
use App\Models\Album;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorealbumRequest;
use App\Http\Requests\UpdatealbumRequest;
use App\Http\Requests\TransportDeleteAlbumRequest;

class AlbumController extends Controller
{

    public function createalbum()
    {
    
        return view('dashboard.albums.create');
    }


    public function viewalbum($id)
    {
        $album = Album::with('pictures')->find($id);
        foreach ($album->pictures as $picture) {
            $picture->url = Media::get_path($picture->src, 'pictures');
        }
        return view('dashboard.albums.view', compact('album'));
    }


    public function editalbumPage($id)
    {
        $album = Album::where('id', $id)->first(); 
        return view('dashboard.albums.edit', compact('album'));
    }


    public function storeInformationalbum(StoreAlbumRequest $request)
    {
        $data = $request->safe()->except(['_token', 'image', 'submit']);
        Album::create($data);
        return redirect()->route('home')->with('success', 'Created Successfull');
    }

    public function updateInformationalbum(UpdateAlbumRequest $request, $id)
    {

        $album = Album::where('id', $id)->first();
        $data = $request->except('_token', '_method', 'submit');

        Album::where('id', $id)->update($data);

        return redirect()->route('home')->with('success', 'Operation Successfull');
    }

    public function Delete_album($id)
    {
        $album = Album::where('id', $id)->first();
        Album::where('id',$id)->delete();
        return redirect()->route('home')->with('success', 'Operation Successfull');
    }

    public function view_transport_page($id)
    {
        $album = Album::where('id', $id)->first();
        $newalbums=Album::all();
        return view('dashboard.albums.transport', compact('album','newalbums'));
    }


    public function Delete_album_transport_images(TransportDeleteAlbumRequest $request,$id)
    {
        $data = $request->except('_token', '_method', 'submit');
        $album = Album::where('id', $id)->first();
        Picture::where('album_id',$id)->update(['album_id' => $data['new_id']]);
        Album::where('id',$id)->delete();
        return redirect()->route('home')->with('success', 'Operation Successfull');
    }

}
