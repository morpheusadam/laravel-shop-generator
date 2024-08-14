<?php

namespace Modules\Support\Sidebar;

use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Maatwebsite\Sidebar\Group;
use Modules\Admin\Sidebar\BaseSidebarExtender;

class SidebarExtender extends BaseSidebarExtender
{
    public function extend(Menu $menu)
    {
        $menu->group(trans('admin::sidebar.system'), function (Group $group) {
            $group->item(trans('admin::sidebar.tools'), function (Item $item) {
                $item->icon('fa fa-wrench');
                $item->weight(20);

                $item->item(trans('support::sitemap.sidebar.sitemap'), function (Item $item) {
                    $item->weight(5);
                    $item->route('admin.sitemaps.create');
                });
            });
        });
    }
}
