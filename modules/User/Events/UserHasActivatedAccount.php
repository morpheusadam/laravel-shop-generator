<?php

namespace Modules\User\Events;

use Modules\User\Entities\User;
use Illuminate\Queue\SerializesModels;

class UserHasActivatedAccount
{
    use SerializesModels;

    /**
     * The user instance.
     *
     * @var User
     */
    public $user;


    /**
     * Create a new event instance.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
}
