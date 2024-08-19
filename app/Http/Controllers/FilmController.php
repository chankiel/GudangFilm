<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Helpers\FileHelper;
use Illuminate\Http\Request;
use App\Http\Resources\FilmCollection;
use App\Http\Requests\StoreFilmRequest;
use Illuminate\Support\Facades\Storage;

class FilmController extends Controller
{

    /**
     * Prepare data for creating row with Eloquent Model.
     */
    public function prepareData(Request $request)
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

        $data['slug'] = FileHelper::cleanFileName($data['title']);

        if ($request->hasFile('video')) {
            $videoFile = $request->file('video');
            $videoFilename = $data['slug'] . '.' . $videoFile->getClientOriginalExtension();
            $videoFile->storeAs('videos/',$videoFilename,'s3');
            $data['video_url'] = Storage::url('videos/'.$videoFilename);
        }
        
        if ($request->hasFile('cover_image')) {
            $imgFile = $request->file('cover_image');
            $imgFilename = $data['slug'] . '.' . $imgFile->getClientOriginalExtension();
            $imgFile->storeAs('cover_images/',$imgFilename,'s3');
            $data['cover_image_url'] = Storage::url('cover_images/'.$imgFilename);
        }        
        
        return $data;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filmQuery = Film::query();
        $str = $request->query('q');
        if ($str) {
            $filmQuery->where('title', $str)
                ->orWhere('director', $str);
        }
        $films = $filmQuery->get();

        if ($films->isEmpty()) {
            return new FilmCollection('error', 'Film not found', $films);
        }
        return new FilmCollection('success', 'Film(s) found', $films);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFilmRequest $request){
        try {
            $data = $this->prepareData($request);

            $film = Film::createFilm($data);
            return new FilmCollection('success', 'Film added successfully', collect([$film]));
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $film = Film::find($id);

        if (!$film) {
            return new FilmCollection('error', 'Film not found', collect());
        }

        return new FilmCollection("success", "Film found", collect([$film]));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreFilmRequest $request, string $id)
    {

        $film = Film::find($id);

        if (!$film) {
            return new FilmCollection('error', 'Film not found', collect());
        }

        $data = $this->prepareData($request);
        $film->update($data);

        return new FilmCollection("success", "Film updated successfully", collect([$film]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $film = Film::find($id);

        if (!$film) {
            return new FilmCollection('error', 'Film not found', collect());
        }

        FileHelper::deleteFilmAsset($film->video_url);
        FileHelper::deleteFilmAsset($film->cover_image_url);

        $response = new FilmCollection("success", "Film deleted successfully", collect([$film]));

        $film->delete();

        return $response;
    }
}
