<?php

namespace App\Http\Controllers\Admin;

use App\Work;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;


class WorkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $posts = Work::Where('work_design_id',$id)->get();
        return response()->json($posts);

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
    public function store(Request $request)
    {

        //dd($request->file);
        //$post = Work::create($request->all());
        $post = new Work;

        $post->work_design_id = $request->work_design_id;
        $post->title = $request->title;
        $post->description =$request->description;
        $post->type = $request->type;

        if($request->file('file')){
            
            $file = $request->file('file');
            $filename = 'complemento-'.time().'-'.$request->fileName;

            $path = Storage::disk('public')->putFileAs('image/works', $file, $filename );
            $post->file = $path; 

            //$path = Storage::disk('public')->put('image/works', $request->file('file'));
            //actualiza el campo file con la direccion
            //$post->file = asset($path); 
        }

        $post->save();

        return response()->json($post);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Work::find($id);
        Work::find($id)->delete();
        Storage::disk('public')->delete($post->file);

        return response()->json(['data'=> 'Work eliminado correctamente'], Response::HTTP_OK);
        
    }

    public function download($id){

        $post = Work::find($id);
        return Storage::disk('public')->download($post->file);
    }
}
