<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class JWTEvents extends Event
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }

    public function valid(){

    }

    public function notFound(){
        return response()->json([
            "status" => 403,
            "status_message" => "jwt_notfound",
            "data" => null
        ]);
        die();
    }

    public function invalid(){
        return response()->json([
            "status" => 403,
            "status_message" => "jwt_invalid",
            "data" => null
        ]);
        die();
    }

    public function expired(){
        return response()->json([
            "status" => 403,
            "status_message" => "jwt_expired",
            "data" => null
        ]);
        die();
    }

    public function missing(){
        return response()->json([
            "status" => 403,
            "status_message" => "jwt_missing",
            "data" => null
        ]);
        die();
    }
}
