<?php

namespace Modules\Storefront\Http\ViewComposers;

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
            'logo' => $this->getHeaderLogo(),
        ]);
    }


    private function getMedia($fileId)
    {
        return Cache::rememberForever(md5("files.{$fileId}"), function () use ($fileId) {
            return File::findOrNew($fileId);
        });
    }


    private function getHeaderLogo()
    {
        return $this->getMedia(setting('storefront_header_logo'))->path;
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
