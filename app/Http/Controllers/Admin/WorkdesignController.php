<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\WorkDesign;
use App\User;
use App\Category;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

use App\Http\Requests\WorkdesignStoreRequest;
use App\Http\Requests\WorkdesignUpdateRequest;

use Illuminate\Support\Facades\Storage;

class WorkdesignController extends Controller
{   
    public function avancedSearch(Request $request)
    {   

        //dd($request->all());

        $array=[];

        $workdesigns = WorkDesign::where("title","like","%$request->title%")->
                        where("uploadBy","like","%$request->uploadBy%")->
                        where("dependency","like","%$request->dependency%")->
                        where("status","like","%$request->status%")->
                        //where("publishedDate","like","%$request->publishedDate%")->
                        get();
        
        foreach($workdesigns as $workdesign){
            $categoria=$workdesign->category->name; 
        }

        if($request->publishedDate!= null){

            $fecha = explode("-", $request->publishedDate);
            $año = $fecha[0]; // porción1
            $mes = $fecha[1]; // porción2
            $dia = $fecha[2]; // porción2

            foreach($workdesigns as $workdesign){
                $workFecha = explode("-", $workdesign->publishedDate);
                $workaño = $workFecha[0]; // porción1
                $workmes = $workFecha[1]; // porción2
                $workdia = $workFecha[2]; // porción2

                if($mes == $workmes && $año == $workaño){
                    //dd($workdesign->toArray(), "dia", $dia);
                    array_push($array, $workdesign);
                }
                
            }
            return response()->json($array);

        }

        return response()->json($workdesigns);
        
    }

    public function workdesignCategory($id){

        $workdesigns =  WorkDesign::where('category_id',$id)->get();

        foreach($workdesigns as $workdesign){
            $categoria=$workdesign->category->name;
        }
        return response()->json($workdesigns);
    }

    public function workdesignUsers($id){

        $workdesigns =  WorkDesign::where('user_id',$id)->get();

        foreach($workdesigns as $workdesign){
            $categoria=$workdesign->category->name;
        }
        return response()->json($workdesigns);
    }

    public function workdesignTitle($title){

        $workdesigns =  WorkDesign::where("title","like","%$title%")->get();
        foreach($workdesigns as $workdesign){
            $categoria=$workdesign->category->name;
        }
        return response()->json($workdesigns);

    }

    public function workdesignDependency($dependency){

        $workdesigns =  WorkDesign::where("dependency",$dependency)->get();
        foreach($workdesigns as $workdesign){
            $categoria=$workdesign->category->name;
        }
        return response()->json($workdesigns);

    }

    public function workdesignStatus($status){

        $workdesigns =  WorkDesign::where("status",$status)->get();
        foreach($workdesigns as $workdesign){
            $categoria=$workdesign->category->name;
        }
        return response()->json($workdesigns);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $workdesigns = Workdesign::orderBy('id','DESC')->get();
        
        foreach($workdesigns as $workdesign){
            $categoria=$workdesign->category->name;
            //$workdesign->categoryName = $categoria;
            
            
            //Para cuardar toda la categoria sociada
            //$categoria=$workdesign->category->name;
            //Para crear el nuevo atributo
            //$workdesign['nombreCategoria']= $workdesign->category->name;   
        }
        return response()->json($workdesigns);
    }

    public function usersList(){

        $workdesigns =  WorkDesign::pluck('user_id')->all();

        //$users = User::whereIn('id',$workdesigns)->get();

        //todos los usuarios que tienen post 
        $users = User::select('id','name')->whereIn('id',$workdesigns)->get();

        //Todos los usuarios muestra id y name
        //$users = User::all('id','name');

        return $users;
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
    public function store(WorkdesignStoreRequest $request)
    {
        //guarda los datos
        $post= WorkDesign::create($request->all());
        return response()->json($post, Response::HTTP_CREATED);
    }

    public function storeFile($id,Request $request)
    {   
        //$file = $request->file;
        //dd($file);
        //Si no existe un id
        if($id == 0){
            //busca el ultimo post el cual se añadio a la base de datos
            $post = Workdesign::orderBy('id','DESC')->first();
            //si existe el archivo file en el request
            if($request->file('file')){

                $file = $request->file('file');
                $filename = time().'-Design-'.$post->title.'.jpg';
                $path = Storage::disk('public')->putFileAs('image/workDesigns',$file,$filename );
                //path guarda la direccion de la carpeta donde se guarda
                //$path = Storage::disk('public')->put('image/', $request->file('file'));
                //actualiza el campo file con la direccion

                //dd($path);
                $post->file = $path;
                $post->save(); 
                //$post->fill(['file' => asset($path)])->save();   
            }
            return response()->json(['data'=> 'Imagen añadida correctamente'], Response::HTTP_CREATED);

        }else{
            //Si existe id esta editando un post
            $post = WorkDesign::find($id);
            //$resultado = substr($post->file, 22);
            Storage::disk('public')->delete($post->file);

            if($request->file('file')){
                $file = $request->file('file');
                $filename = time().'-Design-'.$post->title.'.jpg';
                $path = Storage::disk('public')->putFileAs('image/workDesigns', $file, $filename );
                //carpeta donde se guarda
                //$path = Storage::disk('public')->put('image/', $request->file('file'));
                //$post->fill(['file' => asset($path)])->save(); 
                $post->file = $path;
                $post->save(); 
                return response()->json([
                    'data'=> 'Imagen actualizada correctamente'
                ], Response::HTTP_CREATED);  
            }
        }

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
        $post = WorkDesign::find($id);
        $post->fill($request->all())->save();
        return response()->json([
    		'data'=> 'Diseño actualizada correctamente'
    	], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
        $post = WorkDesign::find($id);
        WorkDesign::find($id)->delete();

        //$resultado = substr($post->file, 22);
        Storage::disk('public')->delete($post->file);

        return response()->json([
    		'data'=> 'Trabajo eliminado'
        ], Response::HTTP_OK);
    }

    public function download($id){
        $post = WorkDesign::find($id);
        return Storage::disk('public')->download($post->file);
    }


}

