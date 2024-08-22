<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResourceJSON extends JsonResource
{
    protected $status, $message;

    public function __construct($status, $message, $user)
    {
        parent::__construct($user);
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
                'message' => 'User not found',
                'data' => null,
            ];
        }
        
        return [
            'status' => $this->status,
            'message' => $this->message,
            'data' => [
                'id' => (string)$this->id,
                'username' => $this->username,
                'email' => $this->email,
                'balance' => $this->balance,
            ],
        ];
    }
}
