<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class FilmCollection extends ResourceCollection
{

    protected $status, $message;

    public function __construct($status,$message,$films)
    {
        parent::__construct($films);
        $this->status = $status;
        $this->message = $message;
    }
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = null;
        if(!$this->collection->isEmpty()){
            $data = $this->collection->map(function($film){
                return [
                    'id' => (string)$film->id,
                    'title' => $film->title,
                    'description' => $film->description,
                    'director' => $film->director,
                    'release_year' => $film->release_year,
                    'genre' => $film->genres->pluck('genre')->toArray(),
                    'price' => $film->price,
                    'duration' => $film->duration,
                    'video_url' => $film->video_url,
                    'cover_image_url' => $film->cover_image_url,
                    'created_at' => $film->created_at,
                    'updated_at' => $film->updated_at,
                ];
            });
        }
        
        return [
            'status' => $this->status,
            'message' => $this->message,
            'data' => $data,
        ];
    }
}
