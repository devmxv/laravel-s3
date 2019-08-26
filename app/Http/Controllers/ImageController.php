<?php

namespace App\Http\Controllers;

use App\Image;
use App\Http\Requests\StoreImage;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    //---MXV - Agrego más de esto
    private $image;
    public function __construct(Image $image){
        $this->image = $image;
    }

    public function getImages(){
        return view('images')->with('images', auth()->user()->images);
    }

    public function postUpload(StoreImage $request){
        //---supongo que este es la ruta de imagen?
        $path = Storage::disk('s3')->put('images/originals', $request->file);
        $request->merge([
            'size' => $request->file->getClientSize(),
            'path' => $path
        ]);
        $this->image->create($request->only('path','title','size'));
        //---mensaje de confirmación
        return back()->with('success','Image Successfully Saved');

    }

}
