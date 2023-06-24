<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; //Handling http request from lumen
use App\Models\User; //My Model
use App\Traits\ApiResponser; //Standard API response
use DB; // can be use if not using eloquent, you can use DB component in lumen

use Illuminate\Http\Response;

Class UserController extends Controller {
    use ApiResponser;

    protected $primaryKey = 'userId';
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

        return $this -> successReponse($users);
    }

    public function index(){
        $users = User::all();
        return $this -> successReponse($users);
    }
    
    public function add(Request $request){
        
        $rules = [
            'userId' => 'required|max:10',
            'username' => 'required|max:50',
            'password' => 'required|max:50',
            'gender' => 'required|in:Male,Female',
        ];

        $this->validate($request,$rules);

        $users = User::create($request->all());
        
        return $this -> successReponse($users, Response::HTTP_CREATED);
    }

    public function update(Request $request, $id){
        $rules = [
            'userId' => 'required|max:10',
            'username' => 'required|max:50',
            'password' => 'required|max:50',
            'gender' => 'required|in:Male,Female',
        ];

        $this->validate($request ,$rules);
        $users = User::where('userId', $id)->firstOrFail();
        $users->fill($request->all());

        if($users->isClean()){
            return $this->errorResponse('At least one value must change', Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $users->save();
        return $users;
    }

    public function delete($id){
        $users = User::FindOrFail($id);
        $users->delete();
        return $this->successResponse($users);
    }

    public function show($id){
        $users = User::FindOrFail($id);
            return $this -> successReponse($users);
        }
    } 