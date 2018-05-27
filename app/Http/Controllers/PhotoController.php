<?php

namespace App\Http\Controllers;

use App\Photo;
use App\Post;
use App\Profile;
use Image;
use Illuminate\Http\Request;

class PhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $type, $id)
    {
        $request->validate([
            'photo' => 'required|image',
        ]);

        $file = $request->file('photo');
        $originalName = str_replace(' ', '-', str_replace('(', '', str_replace(')', '', $file->getClientOriginalName())));
        $filename = time().$originalName;
        $path = public_path('img/uploads/'.$filename);
        $data = getimagesize($file);
        $width = $data[0];
        $height = $data[1];
        if($width>$height){
            Image::make($file->getRealPath())->crop($height,$height)->save($path);
        }else{
            Image::make($file->getRealPath())->crop($width,$width)->save($path);
        };

        if($type=="profile"){
          $bind = Profile::class;
        }elseif($type=='post'){
            $bind = Post::class;
            $id = Post::orderBy('upload_time', 'desc')->first()->id;
        };

        $photo = new Photo();
        $photo->path = '/img/uploads/'.$filename;
        $photo->photoable_type = $bind;
        $photo->photoable_id = $id;
        $photo->save();
    }

    public function deletePhoto(Request $request)
    {
        $id = $request->id;
        Photo::find($id)->destroy();
        return response()->json(['code' => 200]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function show(Photo $photo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function edit(Photo $photo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Photo $photo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Photo $photo)
    {
        //
    }
}
