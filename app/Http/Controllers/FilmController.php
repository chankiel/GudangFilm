<?php

namespace App\Http\Controllers;

use App\Helpers\JSONHelper;
use App\Http\Requests\StoreFilmRequest;
use App\Models\Film;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\Constraint\FileExists;

class FilmController extends Controller
{

    /**
     * Delete film's asset (video / cover_image).
     */
    public function deleteFilmAsset($asset_url)
    {
        if (is_null($asset_url)) {
            return;
        }
        $storage_path = storage_path('app/' . $asset_url);
        if (!file_exists($storage_path)) {
            return;
        }
        unlink($storage_path);
    }

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
            $data['video_url'] = $videoFile->storeAs('videos', $videoFilename);
        }

        if ($request->hasFile('cover_image')) {
            $imgFile = $request->file('cover_image');
            $imgFilename = $data['title'] . '.' . $imgFile->getClientOriginalExtension();
            $data['cover_image_url'] = $imgFile->storeAs('cover_images', $imgFilename);
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

        $film = Film::create($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Film berhasil ditambahkan',
            'data' => $film,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $film = Film::find($id);

        if (!$film) {
            return response()->json([
                'status' => 'error',
                'message' => 'Film not found',
                'data' => [],
            ], 404);
        }

        return response()->json([
            'status' => "success",
            'message' => "Film found",
            'data' => $film,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $film = Film::find($id);

        if (!$film) {
            return response()->json([
                'status' => 'error',
                'message' => 'Film not found',
                'data' => [],
            ], 404);
        }

        $data = $this->prepareData($request);

        $film->update($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Film berhasil diupdate',
            'data' => $film,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $film = Film::all()->find($id);

        if (!$film) {
            return response()->json([
                'status' => 'error',
                'message' => 'Film not found',
                'data' => [],
            ], 404);
        }

        $this->deleteFilmAsset($film->video_url);
        $this->deleteFilmAsset($film->cover_image_url);

        $response = response()->json([
            'status' => 'success',
            'message' => 'Film berhasil dihapus',
            'data' => $film,
        ], 200);

        $film->delete();
        return $response;
    }
}
