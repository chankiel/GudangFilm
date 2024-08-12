<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Helpers\JwtHelper;
use App\Helpers\JSONHelper;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $str = $request->query('q');
        $users = DB::table('users')
            ->where('username', $str)
            ->get();
        if(empty($users)){
            return JSONHelper::JSONResponse('error','User not found',[]);
        }
        return JSONHelper::JSONResponse('success','User(s) found',$users);
    }

    public function self(Request $request){
        $credentials = JwtHelper::decode($request->cookie('jwt_token'));
        $user = DB::table('users')->where('username',$credentials['usrnm'])->first();
        if(!$user || !Hash::check($credentials['pswrd'],$user->password)){
            return JSONHelper::JSONResponse('error','Credentials doesn\' match',null);
        }

        return JSONHelper::JSONResponse('success','User found',[
            'username'=>$credentials['usrnm'],
            'token'=>$request->bearerToken(),
        ]);
    }

    public function store(StoreUserRequest $request){
        print_r($request->all());
        $user = User::create($request->all());
        return response(null,200);
    }

    public function show(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return JSONHelper::JSONResponse('error','User not found',null,404);
        }

        return JSONHelper::JSONResponse('success','User found',$user);
    }

    public function addBalance(Request $request,string $id){
        $user = User::find($id);

        if (!$user) {
            return JSONHelper::JSONResponse('error','User not found',null,404);
        }

        $increment = (int)$request->input('increment');
        if(!is_numeric($increment)){
            return JSONHelper::JSONResponse('error','Increment must be numeric',[]);
        }
        $increment = (int)$increment;
        if($increment<0){
            return JSONHelper::JSONResponse('error','Increment must be greater equal than 0',[]);
        }

        $user->balance += $increment;
        $user->save();
        
        return JSONHelper::JSONResponse('success','User\'s balance telah ditambah',$user); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::all()->find($id);

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found',
                'data' => [],
            ], 404);
        }

        $response = response()->json([
            'status' => 'success',
            'message' => 'User berhasil dihapus',
            'data' => $user,
        ], 200);

        $user->delete();
        return $response;
    }
}
