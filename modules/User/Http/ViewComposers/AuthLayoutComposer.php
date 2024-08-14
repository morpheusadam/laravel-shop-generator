<?php

namespace Modules\User\Http\ViewComposers;

use Exception;
use Illuminate\View\View;
use Modules\Media\Entities\File;
use Illuminate\Support\Facades\Cache;

class AuthLayoutComposer
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
        $view->with([
            'themeColor' => $this->getThemeColor(),
            'logo' => $this->getAdminLogo(),
        ]);
    }


    private function getMedia($fileId)
    {
        return Cache::rememberForever(md5("files.{$fileId}"), function () use ($fileId) {
            return File::findOrNew($fileId);
        });
    }


    private function getAdminLogo()
    {
        return $this->getMedia(setting('admin_logo'))->path;
    }


    private function getThemeColor()
    {
        try {
            return tinycolor(storefront_theme_color());
        } catch (Exception $e) {
            return tinycolor('#0068e1');
        }
    }
}
