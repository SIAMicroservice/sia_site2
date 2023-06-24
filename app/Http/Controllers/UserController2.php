<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; //Handling http request from lumen
use App\Models\User; //My Model
use App\Traits\ApiResponser; //Standard API response
use DB; // can be use if not using eloquent, you can use DB component in lumen
use App\Models\UserJob; //USERJOB MODEL
use Illuminate\Http\Response;

Class UserController2 extends Controller {
    use ApiResponser;

    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    public function getUsers()
    {
        // Eloquent Style
        // $users = User::all();

        // sql string as parameter
        $users = DB::connection('mysql')
        ->select("Select * from tbluser");

        return $this -> successResponse($users);
    }

    public function index(){
         $users = User::all();
         return $this -> successResponse($users);
    }
    
    // ADD FUNCTION
    public function add(Request $request){
        
        $rules = [
            'userId' => 'required|max:50',
            'username' => 'required|max:50',
            'password' => 'required|max:50',
            'gender' => 'required|in:Male,Female',
            'jobid' => 'required|numeric|min:1|not_in:0',   
        ];

        $this->validate($request,$rules);
        // $userjob = UserJob::findOrFail($request->jobid);
        $users = User::create($request->all());
        return $this -> successResponse($users, Response::HTTP_CREATED);
    }

    public function show($id){

        $users = User::findOrFail($id);
        return $this -> successResponse($users);


        // $users = User::where('userId', $id)->first();
        // if ($users){
        //     return $this -> successResponse($users);
        // }
        // {
        //     return $this-> errorResponse('User Does Not Exist', Response::HTTP_NOT_FOUND);
        // }
        
    }

     // UPDATE FUNCTION
     public function updateUser(Request $request, $id)
     {
        $rules = [
            'userId' => 'required|max:50',
            'username' => 'required|max:50',
            'password' => 'required|max:50',
            'gender' => 'required|in:Male,Female',
            'jobid' => 'required|numeric|min:1|not_in:0',
        ];

         $this->validate($request,$rules);
         $users = User::where('userId', $id)->firstOrFail();
         $users->fill($request->all());
         
        //  IF NO CHANGE HAPPENED
         if ($users->isClean()){
            return $this->errorResponse('At least one value must change', Response::HTTP_UNPROCESSABLE_ENTITY);
         }
         $users->save();
         return $this -> successResponse($users);
     } 
    //  DELETE FUNCTION
     public function deleteUser($id) {
        $users = User::findOrFail($id);
        $users->delete();
        return $this -> successResponse($users);

        // $users = User::where('userId', $id)->delete();

        // if($users){
        //     return $this -> successResponse($users);
        // }
        // else{
        //     return $this->errorResponse('User ID Does Not Exists', Response::HTTP_NOT_FOUND);
        // }
    }
    
}


