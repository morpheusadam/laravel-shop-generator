<?php

namespace Modules\User\Http\ViewComposers;

use Illuminate\View\View;

class CurrentUserComposer
{
    /**
     * Bind data to the view.
     *
     * @param View $view
     *
     * @return void
     */
    public function compose($view)
    {
        $view->with('currentUser', auth()->user());
    }
}
