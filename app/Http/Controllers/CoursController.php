<?php

namespace App\Http\Controllers;

use App\Models\cours;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;



class CoursController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return cours::all();
    }

    /**
     * search a certain course in the storage.
     */
    public function search($search)
    {
        $cour = cours::where('nom','like',"%$search%")->get();
      

        if(count($cour)>0){
            return $cour;
        }else{
            $message= ['Message'=>"le cour que vous recherchez n'a été trouvé 😥"];

            return response()->json($message,203);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $rules = array(
            'nom'=>'required|max:30',
            'description'=>'required|min:10'
        );
        
        $validator = Validator::make($request->all(),$rules);

        if($validator->fails())
        {
            return response($validator->errors(), 203);
        }else{

            $cour = new cours();
            $cour->nom=$request->nom;
            $cour->description= $request->description;
            $resultat = $cour->save();
    
            if($resultat){
                
                return ['Message'=>"le cour a été enregister avec succès😊"];
            }else{
                
                return ['Message'=>"le cour n'a été enregister😥"];
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($cours)
    {
        
        
        $cour = ((int)$cours != 0 )  ? cours::findorFail($cours) : cours::all();
        
        return $cour;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $cour = cours::find($request->id);

        $rules = [
            'nom'=>'required|max:30',
            'description'=>'required|min:10'
        ];

        $validation = Validator::make($request->all(),$rules);

        if($validation->fails()){
            return response()->json($validation->errors(), 203);
        }else{

            $cour->nom=$request->nom;
            $cour->description= $request->description;
    
            $resultat = $cour->save();
    
            if($resultat){
                return ['Message'=>"le cour a été modifié avec succès😊"];
            }else{
                return ['Message'=>"le cour n'a été modifié 😥"];
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $cours)
    {
        $cour = cours::find($cours->id);

        if(!$cour){
            $message =  ['Message'=>"Le cour que vous essayez de suprimer n'esiste pas😥"];
            return response()->json($message, 203);
        }
        $resultat=$cour->delete();

        if($resultat){
            return ['Message'=>"le cour a été supprimé avec succès😊"];
        }else{
            return ['Message'=>"le cour n'a été supprimé 😥"];
        }
    }
}
