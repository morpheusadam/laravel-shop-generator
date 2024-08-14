<?php

namespace Modules\Setting\Events;

use Modules\Setting\Entities\Setting;
use Illuminate\Queue\SerializesModels;

class SettingSaved
{
    use SerializesModels;

    /**
     * The setting model.
     *
     * @var Setting
     */
    public $setting;


    /**
     * Create a new event instance.
     *
     * @param Setting $order
     *
     * @return void
     */
    public function __construct(Setting $setting)
    {
        $this->setting = $setting;
    }
}
