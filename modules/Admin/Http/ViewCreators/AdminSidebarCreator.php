<?php

namespace Modules\Admin\Http\ViewCreators;

use Illuminate\View\View;
use Modules\Admin\Sidebar\AdminSidebar;
use Maatwebsite\Sidebar\Presentation\SidebarRenderer;

class AdminSidebarCreator
{
    /**
     * @var AdminSidebar
     */
    protected $sidebar;

    /**
     * @var SidebarRenderer
     */
    protected $renderer;


    /**
     * @param AdminSidebar $sidebar
     * @param SidebarRenderer $renderer
     */
    public function __construct(AdminSidebar $sidebar, SidebarRenderer $renderer)
    {
        $this->sidebar = $sidebar;
        $this->renderer = $renderer;
    }


    public function create(View $view)
    {
        $view->sidebar = $this->renderer->render($this->sidebar);
    }
}
