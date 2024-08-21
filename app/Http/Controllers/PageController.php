<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Helpers\AuthHelper;
use App\Helpers\FileHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PageController extends Controller
{

    public function handleQuery(Request $request,$filmQuery,$qtyFilm){
        $query = $request->input('search');
        if ($query) {
            $query = strtolower($query);
            $filmQuery->whereRaw('LOWER(title) LIKE ?', ["%{$query}%"])
                ->orWhereRaw('LOWER(director) LIKE ?', ["%{$query}%"]);
        }
        return $filmQuery->paginate($qtyFilm);
    }
    public function home(Request $request)
    {
        $authed = AuthController::check($request);
        $filmQuery = Film::query();

        $films = $this->handleQuery($request,$filmQuery,14);
        return view('filmsList', ['films' => $films, 'authed' => $authed,'title'=>""]);
    }

    public function filmDetail(Request $request, Film $film)
    {
        $authed = AuthController::check($request);

        $genres = $film->genres->pluck('genre')->toArray();
        $bought = $authed->bought()->where('id', $film->id)->exists();
        $wished = $authed->wishlist()->where('id', $film->id)->exists();
        
        $comments = $film->comments()->orderBy('created_at','desc')->get();
        $commentsCount = $comments->count();

        $rating = $authed->rated()->where('id', $film->id)->first();
        if(!$rating){
            $rating = null;
        }else{
            $rating = $rating->pivot->rating;
        }

        return view('filmDetail', [
            'film' => $film,
            'authed' => $authed,
            'genres' => $genres,
            'bought' => $bought,
            'wished' => $wished,
            'rating' => $rating,
            'comments' => $comments,
            'commentsCount' => $commentsCount,
            'formattedDuration' => FileHelper::formatDuration($film->duration),
        ]);
    }

    public function myfilms(Request $request)
    {
        $authed = AuthController::check($request);
        $filmQuery = $authed->bought();
        $films = $this->handleQuery($request,$filmQuery,5);
        return view('filmsList', ['films' => $films, 'authed' => $authed, 'title' => "My Films"]);
    }

    public function wishlist(Request $request){
        $authed = AuthController::check($request);
        $filmQuery = $authed->wishlist();
        $films = $this->handleQuery($request,$filmQuery,5);
        return view('filmsList', ['films' => $films, 'authed' => $authed, 'title' => "WishList"]);
    }

    public function register()
    {
        return view('register');
    }

    public function login()
    {
        return view('login');
    }
}
