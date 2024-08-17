<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Helpers\JwtHelper;
use App\Helpers\JSONHelper;
use App\Http\Requests\StoreUserRequest;
use App\Models\Film;
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
            'token'=>$request->cookie('jwt_token'),
        ]);
    }

    public function store(StoreUserRequest $request){
        $data = $request->except('_token');
        $user = User::create($data);
        return redirect('/login')->with('success','User created');
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
            return JSONHelper::JSONResponse('error','User not found',null,404);
        }

        $response = JSONHelper::JSONResponse('success','User berhasil dihapus',null,200);

        $user->delete();
        return $response;
    }

    public function buyFilm(Request $request, $id){
        $user = AuthController::check($request);

        if ($user->films()->where('id', $id)->exists()) {
            return redirect()->back()->with('error', 'You have already bought this film.');
        }

        $film = Film::find($id);

        if (!$film) {
            return redirect()->back()->with('error', 'Film not found.');
        }

        if ($user->balance < $film->price) {
            return redirect()->back()->with('error', 'You don\'t have enough balance to buy this film.');
        }

        $user->balance -= $film->price;
        $user->save();

        $user->films()->attach($film->id);

        return redirect()->back()->with('success', 'Film purchased successfully.');
}

}
