<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Film;
use App\Models\User;
use App\Helpers\JSONHelper;
use Illuminate\Http\Request;
use App\Http\Resources\UserResourceJSON;
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
        if ($str) {
            $userQuery->where('username', $str);
        }
        $users = $userQuery->get();

        if ($users->isEmpty()) {
            return new UserCollection('error', 'User not found', $users);
        }
        return new UserCollection('success', 'User(s) found', $users);
    }

    public function store(StoreUserRequest $request)
    {
        $data = $request->except('_token');
        $user = User::create($data);
        return redirect('/login')->with('success', 'User created');
    }

    public function show(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return new UserResourceJSON('error', 'User not found', null);
        }

        return new UserResourceJSON('success', 'User found', $user);
    }

    public function addBalance(Request $request, string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return new UserResourceJSON('error', 'User not found', null);
        }

        $increment = (int)$request->input('increment');
        if (!is_numeric($increment)) {
            return new UserResourceJSON('error', 'Increment must be numeric', $user);
        }

        $increment = (int)$increment;
        if($increment<0){
            return JSONHelper::JSONResponse('error','Increment must be greater equal than 0',[]);
        }

        $user->balance += $increment;
        $user->save();

        return new UserResourceJSON('success', 'User\'s balance incremented successfully', $user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return new UserResourceJSON('error', 'User not found', null);
        }

        $response = new UserResourceJSON('success', 'User berhasil dihapus', $user);

        $user->delete();
        return $response;
    }

    public function buyFilm(Request $request, $id)
    {
        $user = AuthController::check($request);

        $film = Film::find($id);
        if (!$film) {
            return redirect()->back()->with('error', 'Film not found.');
        }

        if ($user->bought()->where('id', $id)->exists()) {
            return redirect()->back()->with('error', 'You have already bought this film.');
        }

        if ($user->balance < $film->price) {
            return redirect()->back()->with('error', 'You don\'t have enough balance to buy this film.');
        }

        $user->buyFilm($film);

        return redirect()->back()->with('success', 'Film purchased successfully.');
    }

    public function wishFilm(Request $request, $id)
    {
        $user = AuthController::check($request);

        $film = Film::find($id);

        if (!$film) {
            return redirect()->back()->with('error', 'Film not found.');
        }

        if ($user->wishlist()->where('id', $id)->exists()) {
            return redirect()->back()->with('error', 'You have already bought this film.');
        }


        $user->wishlist()->attach($film->id);

        return redirect()->back()->with('success', 'Film added to your wishlist!');
    }

    public function unwishFilm(Request $request, $id)
    {
        $user = AuthController::check($request);

        $film = Film::find($id);

        if (!$film) {
            return redirect()->back()->with('error', 'Film not found.');
        }

        if (!$user->wishlist()->where('id', $id)->exists()) {
            return redirect()->back()->with('error', 'You haven\'t bought this film.');
        }


        $user->wishlist()->detach($film->id);

        return redirect()->back()->with('success', 'Film removed from your wishlist!');
    }

    public function rateFilm(Request $request, Film $film, $rating)
    {
        $user = AuthController::check($request);

        if (!$film) {
            return redirect()->back()->with('error', 'Film not found.');
        }

        $user->rated()->syncWithoutDetaching([
            $film->id => ['rating' => $rating]
        ]);

        return redirect()->back();
    }

    public function commentFilm(Request $request, Film $film)
    {
        $user = AuthController::check($request);

        if (!$film) {
            return redirect()->back()->with('error', 'Film not found.');
        }

        $now = Carbon::now();
        $user->commented()->attach([
            $film->id => [
                'comment' => $request->input('comment'),
                'created_at' => $now,
                'updated_at' => $now,
            ]
        ]);

        return redirect()->back();
    }
}
