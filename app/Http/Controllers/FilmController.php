<?php

namespace App\Http\Controllers;

use App\Helpers\FileHelper;
use App\Models\Film;
use App\Models\Genre;
use App\Helpers\JSONHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreFilmRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\Constraint\FileExists;

class FilmController extends Controller
{

    /**
     * Prepare data for creating row with Eloquent Model.
     */
    public function prepareData($request)
    {
        $data = $request->only([
            'title',
            'description',
            'director',
            'genres',
            'release_year',
            'price',
            'duration',
        ]);

        if ($request->hasFile('video')) {
            $videoFile = $request->file('video');
            $videoFilename = $data['title'] . '.' . $videoFile->getClientOriginalExtension();
            $data['video_url'] = $videoFile->storeAs('videos', $videoFilename,'public');
        }

        if ($request->hasFile('cover_image')) {
            $imgFile = $request->file('cover_image');
            $imgFilename = $data['title'] . '.' . $imgFile->getClientOriginalExtension();
            $data['cover_image_url'] = $imgFile->storeAs('cover_images', $imgFilename,'public');
        }
        return $data;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $str = $request->query('q');
        $films = DB::table('films')
            ->where('title', $str)
            ->orWhere('director', $str)
            ->get();
        
        if($films->isEmpty()){
            return JSONHelper::JSONResponse('error','Film not found',[]);
        }
        return JSONHelper::JSONResponse('success','Film(s) found',$films);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFilmRequest $request)
    {
        $data = $this->prepareData($request);
        Film::createFilm($data);
        return JSONHelper::JSONResponse('success','Film berhasil ditambahkan',$data,201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $film = Film::find($id);

        if (!$film) {
            return JSONHelper::JSONResponse('error','Film not found',[],404);
        }

        $genres = DB::table('film_genres')->where('film_id',$film->id)->value('genre');

        return JSONHelper::JSONResponse("success","Film found",
            [$film,'genres' => $genres],200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $film = Film::find($id);

        if (!$film) {
            return JSONHelper::JSONResponse('error','Film not found',[],404);
        }

        $data = $this->prepareData($request);

        $film->update($data);

        return JSONHelper::JSONResponse("success","Film berhasil diupdate",$film,200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $film = Film::all()->find($id);

        if (!$film) {
            return JSONHelper::JSONResponse('error','Film not found',[],404);
        }

        FileHelper::deleteFilmAsset($film->video_url);
        FileHelper::deleteFilmAsset($film->cover_image_url);

        $response = JSONHelper::JSONResponse("success","Film berhasil dihapus",$film,200);

        $film->delete();
        return $response;
    }
}
