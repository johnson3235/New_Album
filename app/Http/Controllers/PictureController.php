<?php

namespace App\Http\Controllers;

use App\Traits\Media;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Models\Picture;
use App\Models\Album;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePictureRequest;
use App\Http\Requests\UpdatePictureRequest;

class PictureController extends Controller
{

    public function index()
    {
        $pictures = Picture::with('album')->get();
        foreach ($pictures as $picture) {
            // Generate the URL for the image on the 'private' disk
            $picture->url = Media::get_path($picture->src, 'pictures');
        }
    
        return view('dashboard.pictures.index',compact('pictures'));
    }

    public function createpicture()
    {
        $albums = Album::all();
        return view('dashboard.pictures.create',compact('albums'));
    }


    public function editpicturePage($id)
    {
        $picture =Picture::where('id', $id)->first();
        $albums = Album::all();
        return view('dashboard.pictures.edit', compact('picture','albums'));
    }


    public function storeInformationpicture(StorePictureRequest $request)
    {
     
        $photoName = Media::upload($request->file('src'),'pictures');
        $data = $request->safe()->except(['_token', 'src', 'submit']);
        $data['src'] = $photoName;
   
        Picture::create($data);
 
        return redirect()->route('picture.home')->with('success', 'Created Successfull');
    }

    public function updateInformationpicture(UpdatePictureRequest $request, $id)
    {

        $picture = Picture::where('id', $id)->first();
        $data = $request->except('_token', '_method', 'submit');
        if ($request->has('src')) {

            $newPhotoName = Media::upload($request->file('src'),'pictures');
            Media::delete("images/pictures/{$picture->src}");

            $data['src'] = $newPhotoName;
        }

        Picture::where('id', $id)->update($data);
        return redirect()->route('picture.home')->with('success', 'Operation Successfull');
    }

    public function Deletepicture($id)
    {
        $picture = Picture::where('id', $id)->first();
        Picture::where('id',$id)->delete();
        return redirect()->back()->with('success', 'Operation Successfull');
    }

}
