<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
{
    protected $message,$status;

    public function __construct($status,$message,$users)
    {
        parent::__construct($users);
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
            $data = $this->collection->map(function($user){
                return [
                    'id' => $user->id,
                    'username' => $user->username,
                    'email' => $user->email,
                    'balance' => $user->balance,
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
