<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\User;
use App\Helpers\JwtHelper;
use App\Helpers\JSONHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserCollection;
use App\Http\Requests\StoreUserRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $userQuery = User::query();
        $str = $request->query('q');
        if($str){
            $userQuery->where('username', $str);
        }
        $users = $userQuery->get();
        
        if($users->isEmpty()){
            return new UserCollection('error','User not found',$users);
        }
        return new UserCollection('success','User(s) found',$users);
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
            return new UserCollection('error','User not found',collect());
        }

        return new UserCollection('success','User found',collect([$user]));
    }

    public function addBalance(Request $request,string $id){
        $user = User::find($id);

        if (!$user) {
            return new UserCollection('error','User not found',collect());
        }

        $increment = (int)$request->input('increment');
        if(!is_numeric($increment)){
            return new UserCollection('error','Increment must be numeric',collect([$user]));
        }

        $increment = (int)$increment;
        // if($increment<0){
        //     return JSONHelper::JSONResponse('error','Increment must be greater equal than 0',[]);
        // }

        $user->balance += $increment;
        $user->save();
        
        return new UserCollection('success','User\'s balance incremented successfully',collect([$user])); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return new UserCollection('error','User not found',collect());
        }

        $response = new UserCollection('success','User berhasil dihapus',collect([$user]));

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
