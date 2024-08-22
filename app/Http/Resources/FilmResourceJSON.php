<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FilmResourceJSON extends JsonResource
{
    protected $status, $message;

    public function __construct($status, $message, $film)
    {
        parent::__construct($film);
        $this->status = $status;
        $this->message = $message;
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        if ($this->resource === null) {
            return [
                'status' => false,
                'message' => 'Film not found',
                'data' => null,
            ];
        }
        return [
            'status' => $this->status,
            'message' => $this->message,
            'data' => [
                'id' => (string)$this->id,
                'title' => $this->title,
                'description' => $this->description,
                'director' => $this->director,
                'release_year' => $this->release_year,
                'genre' => $this->genres->pluck('genre')->toArray(),
                'price' => $this->price,
                'duration' => $this->duration,
                'video_url' => $this->video_url,
                'cover_image_url' => $this->cover_image_url,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ]
        ];
    }
}
