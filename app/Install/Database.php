<?php

namespace FleetCart\Install;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;

class Database
{
    public function setup($request): void
    {
        $this->setupDatabaseConnection($request);
        $this->setEnvVariables($request);
        $this->migrateDatabase();
    }


    private function setupDatabaseConnection($request): void
    {
        DB::purge('mysql');
        $this->setupDatabaseConnectionConfig($request);
        DB::connection('mysql')->reconnect();
        DB::connection('mysql')->getPdo();
    }


    private function setupDatabaseConnectionConfig($request): void
    {
        config([
            'database.default' => 'mysql',
            'database.connections.mysql.host' => $request['db_host'],
            'database.connections.mysql.port' => $request['db_port'],
            'database.connections.mysql.database' => $request['db_database'],
            'database.connections.mysql.username' => $request['db_username'],
            'database.connections.mysql.password' => $request['db_password'],
        ]);
    }


    private function setEnvVariables($request): void
    {
        $env = DotenvEditor::load();

        $env->setKey('DB_HOST', $request['db_host']);
        $env->setKey('DB_PORT', $request['db_port']);
        $env->setKey('DB_DATABASE', $request['db_database']);
        $env->setKey('DB_USERNAME', $request['db_username']);
        $env->setKey('DB_PASSWORD', $request['db_password']);

        $env->save();
    }


    private function migrateDatabase(): void
    {
        Artisan::call('migrate', ['--force' => true]);
    }
}
