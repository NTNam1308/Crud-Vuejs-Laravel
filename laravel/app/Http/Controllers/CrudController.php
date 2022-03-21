<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Crud;

class CrudController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function index()
   {
       $crud = Crud::all('id', 'email', 'address');
       return response()->json( $crud );
   }

   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function store(Request $request)
   {
       
       $validatedData = $request->validate([
           'email'    => 'required|min:1|max:64',
           'address' => 'required|min:1|max:128',
       ]);
       $template = new Crud();
       $template->email = $request->input('email');
       $template->address = $request->input('address');
       $template->save();
       return response()->json( ['status' => 'success'] );
   }

   /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function show(Request $request ){
       return response()->json( [ 'template' => Crud::find($request -> id) ] );
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function edit($id)
   {
       return response()->json( [ 'template' => Crud::find($id) ] );
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function update(Request $request)
   {
    $validatedData = $request->validate([
        'email'    => 'required|min:1|max:64',
        'address' => 'required|min:1|max:128',
    ]);
    $template = Crud::Find($request->id);
    $template->email = $request->input('email');
    $template->address = $request->input('address');
    $template->save();
    return response()->json( ['status' => 'success'] );
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function destroy( Request $request)
   {
       $template = Crud::find($request->id);
       if($template){
           $template->delete();
       }
       return response()->json( ['status' => 'success'] );
   }

}
