<?php

namespace Modules\Product\Listeners;

use Exception;
use Modules\Product\RecentlyViewed;
use Modules\Product\Events\ProductViewed;

class AddToRecentlyViewed
{
    /**
     * The recently viewed instance.
     *
     * @var RecentlyViewed
     */
    private $recentlyViewed;


    /**
     * Create a new event listener.
     *
     * @param RecentlyViewed $recentlyViewed
     */
    public function __construct(RecentlyViewed $recentlyViewed)
    {
        $this->recentlyViewed = $recentlyViewed;
    }


    /**
     * Handle the event.
     *
     * @param ProductViewed $event
     *
     * @return void
     */
    public function handle(ProductViewed $event)
    {
        try {
            $this->recentlyViewed->store($event->product);
        } catch (Exception) {
            //
        }
    }
}
