<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Helpers\AuthHelper;
use App\Helpers\FileHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PageController extends Controller
{
    public function home(Request $request)
{
    $authed = AuthController::check($request);
    $query = $request->input('search');
    $filmQuery = Film::query();

    if ($query) {
        $query = strtolower($query);
        $filmQuery->whereRaw('LOWER(title) LIKE ?', ["%{$query}%"])
                  ->orWhereRaw('LOWER(director) LIKE ?', ["%{$query}%"]);
    }
    $films = $filmQuery->paginate(16);
    return view('home', ['films' => $films, 'authed' => $authed]);
}


    public function filmDetail(Request $request, Film $film)
    {
        $authed = AuthController::check($request);
        $genres = $film->genres->pluck('genre')->toArray();
        $bought = $authed->films()->where('id', $film->id)->exists();
        return view('filmDetail', [
            'film' => $film,
            'authed' => $authed,
            'genres' => $genres,
            'bought' => $bought,
            'formattedDuration' => FileHelper::formatDuration($film->duration),
        ]);
    }

    public function myfilms(Request $request){
        $authed = AuthController::check($request);
        $query = $request->input('search');
        $filmQuery = $authed->films();
        if ($query) {
            $query = strtolower($query);
            $filmQuery->whereRaw('LOWER(title) LIKE ?', ["%{$query}%"])
                      ->orWhereRaw('LOWER(director) LIKE ?', ["%{$query}%"]);
        }
        $films = $filmQuery->paginate(5);
        return view('myfilms', ['films' => $films, 'authed' => $authed]);
    }

    public function register(){
        return view('register');
    }

    public function login(){
        return view('login');
    }
}
