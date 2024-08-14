<?php

namespace Modules\Blog\Sidebar;

use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Maatwebsite\Sidebar\Group;
use Modules\Admin\Sidebar\BaseSidebarExtender;

class SidebarExtender extends BaseSidebarExtender
{
    public function extend(Menu $menu)
    {
        $menu->group(trans('admin::sidebar.content'), function (Group $group) {
            $group->item(trans('blog::admin.blog'), function (Item $item) {
                $item->weight(35);
                $item->icon('fa fa-pencil-square-o');
                $item->route('admin.blog_posts.index');
                $item->authorize(
                    $this->auth->hasAnyAccess([
                        'admin.blog_posts.index',
                        'admin.blog_categories.index',
                        'admin.blog_tags.index',
                    ])
                );
                $item->item(trans('blog::admin.posts'), function (Item $item) {
                    $item->weight(5);
                    $item->route('admin.blog_posts.index');
                    $item->authorize(
                        $this->auth->hasAccess('admin.blog_posts.index')
                    );
                });

                $item->item(trans('blog::admin.categories'), function (Item $item) {
                    $item->weight(10);
                    $item->route('admin.blog_categories.index');
                    $item->authorize(
                        $this->auth->hasAccess('admin.blog_categories.index')
                    );
                });

                $item->item(trans('blog::admin.tags'), function (Item $item) {
                    $item->weight(15);
                    $item->route('admin.blog_tags.index');
                    $item->authorize(
                        $this->auth->hasAccess('admin.blog_tags.index')
                    );
                });
            });
        });
    }
}
