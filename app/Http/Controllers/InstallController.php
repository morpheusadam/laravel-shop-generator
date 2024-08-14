<?php

namespace FleetCart\Http\Controllers;

use Exception;
use FleetCart\Install\App;
use FleetCart\Install\Store;
use Illuminate\Http\Response;
use FleetCart\Install\Database;
use FleetCart\Install\Permission;
use Illuminate\Http\JsonResponse;
use FleetCart\Install\Requirement;
use Illuminate\Routing\Controller;
use Illuminate\Contracts\View\View;
use FleetCart\Install\AdminAccount;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use FleetCart\Http\Requests\InstallRequest;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;
use Illuminate\Contracts\Foundation\Application;
use FleetCart\Http\Middleware\RedirectIfInstalled;

class InstallController extends Controller
{
    public function __construct()
    {
        $this->middleware(RedirectIfInstalled::class);
    }


    public function installation(Requirement $requirement, Permission $permission): Factory|View|Application
    {
        return view('install.install', compact('requirement', 'permission'));
    }


    public function install(
        InstallRequest $request,
        Database       $database,
        AdminAccount   $admin,
        Store          $store,
        App            $app
    ): JsonResponse
    {
        @set_time_limit(0);

        try {
            Artisan::call('optimize:clear');

            $database->setup($request);
            $admin->setup($request);
            $store->setup($request);
            $app->setup();

            DotenvEditor::setKey('APP_INSTALLED', 'true')->save();

            Artisan::call('key:generate', ['--force' => true]);

            $success = true;
            $message = "Congratulations! FleetCart installed successfully";
        } catch (Exception $e) {
            $success = false;
            $message = $e->getMessage();

            try {
                if (Schema::hasTable('migrations')) {
                    Artisan::call('migrate:rollback', ['--force' => true]);
                }
            } catch (Exception $e) {
                $message .= '<br><br>' . $e->getMessage();
            }
        } finally {
            return response()->json(
                [
                    'success' => $success,
                    'message' => $message,
                ],
                $success ? Response::HTTP_OK : Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
