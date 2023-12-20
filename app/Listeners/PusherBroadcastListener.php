<?php

namespace App\Listeners;

use App\Events\PusherBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class PusherBroadcastListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(PusherBroadcast $event): void
    {
        //
    }
}
