<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $res = [
            'data' => null,
            'message' => '',
            'success' => true            
        ];        
        $res['data'] = User::all();  
        return   $res;    
     
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        /*$error = \Illuminate\Validation\ValidationException::withMessages([
            'field_name_1' => ['Validation Message #1'],
            'field_name_2' => ['Validation Message #2'],
         ]);
         throw $error;*/
        $res = [
            'data' => null,
            'message' => 'Utente Creato',
            'success' => true    ,
            'log' => ''        
        ];                
        try{
            $data = $request->except('id'); //tutto tranne id 
            $user = new User();
            //$user->name = $request->input('name'); //campo per campo
            //$user->phone = $request->input('phone'); //campo per campo
            $user->fill($data); //tutto in una volta 
            $res['log'] = $data;
            $user->save();
            $res['data'] =$user;
             
        }
        catch (\Exception $e){
            $res['success'] = false;
            $res['message'] = 'Errore nel salvataggio:';
            $res['message'] .=  $e->  getMessage();   
        }   
        return $res;     
    }

    /**
     * Display the specified resource.
     */
    public function show($user)
    {
        $res = [
            'data' => null,
            'message' => null,
            'success' => true            
        ];        
        try{
            $res['data'] = User::findOrFail($user);
        }
        catch (\Exception $e){
            $res['success'] = false;
            $res['message'] = 'Utente non trovato:';
            $res['message'] .=  $e->  getMessage();   
        }
        return $res;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $user)
    {
        $res = [
            'data' => null,
            'message' => '',
            'success' => true            ,
            'log' =>''
        ];

        try{
            $data = $request->except('id'); //tutto tranne id 
            $user = User::findOrFail($user); //Cerca utente 
            $user->update($data)    ; //Lo aggiorna
            $res['data'] = $user;
            
            $res['log'] = $request; //ritorna l'utent aggiornato   
            return $res;  
        }
        catch(\Exception $e){
            $res['success'] = false;
            $res['message'] = $e->getMessage();
        }; 
        return $res;       
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $res = [
            'data' => null,
            'message' => '',
            'success' => true            ,
            'log' =>''
        ];

        try{
            $res['success'] = $user->delete();
            if (!$res['success']){
                $res['message'] = 'errore generico in cancellazione';    
            }
            return $res;
        }
        

        catch(\Exception $e){
            $res['success'] = false;
            $res['message'] = $e->getMessage();
            $res['log'] = '2';
        };         
        return $res;       
    }
}
