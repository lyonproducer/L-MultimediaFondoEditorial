<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\WorkDesign;
use App\Category;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

use App\Http\Requests\WorkdesignStoreRequest;
use App\Http\Requests\WorkdesignUpdateRequest;

use Illuminate\Support\Facades\Storage;

class WorkdesignController extends Controller
{   
    public function workdesignCategory($id){

        $workdesigns =  WorkDesign::where('category_id',$id)->get();

        foreach($workdesigns as $workdesign){
            //$categoria= Category::Where('id',$workdesign->category_id)->value('name');
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
        $workdesigns = Workdesign::orderBy('id','ASC')->get();
        
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
        //Primer valida la informacion
        $post= WorkDesign::create($request->all());
        //Imagen
        if($request->file('file')){
            //carpeta donde se guarda
            $path = Storage::disk('public')->put('image', $request->file('file'));
            $post->fill(['file' => asset($path)])->save();
        }

        return response()->json([
    		'data'=> 'Diseño añadido correctamente'
    	], Response::HTTP_CREATED);
    }

    public function storeFile($id,Request $request)
    {   
        //Si no existe un id
        if(empty($id)){
            //busca el ultimo post el cual se añadio a la base de datos
            $post = Workdesign::orderBy('id','DESC')->first();
            //si existe el archivo file en el request
            if($request->file('file')){
                //path guarda la direccion de la carpeta donde se guarda
                $path = Storage::disk('public')->put('image', $request->file('file'));
                //actualiza el campo file con la direccion
                $post->fill(['file' => asset($path)])->save();   
            }
            return response()->json(['data'=> 'Imagen añadida correctamente'], Response::HTTP_CREATED);

        }
        //Si existe id esta editando un post
        $post = WorkDesign::find($id);
        $resultado = substr($post->file, 22);
        Storage::disk('public')->delete($resultado);

        if($request->file('file')){
            //carpeta donde se guarda
            $path = Storage::disk('public')->put('image', $request->file('file'));
            $post->fill(['file' => asset($path)])->save(); 
            return response()->json([
                'data'=> 'Imagen actualizada correctamente'
            ], Response::HTTP_CREATED);  
        }else

        return response()->json(['data'=> 'no se encontro imagen']); 
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

        $resultado = substr($post->file, 22);
        Storage::disk('public')->delete($resultado);

        return response()->json([
    		'data'=> 'Trabajo eliminado'
        ], Response::HTTP_OK);
    }


}

