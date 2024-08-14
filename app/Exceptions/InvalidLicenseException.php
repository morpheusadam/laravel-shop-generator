<?php

namespace FleetCart\Exceptions;

use Exception;
use Illuminate\Http\RedirectResponse;

class InvalidLicenseException extends Exception
{
    protected $message;


    public function __construct($message)
    {
        parent::__construct();

        $this->message = $message;
    }


    public function render(): RedirectResponse
    {
        return redirect()->route('license.create')
            ->with('error', $this->message);
    }
}
