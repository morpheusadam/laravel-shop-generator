<?php

namespace FleetCart\Console\Commands;

use Illuminate\Console\Command;
use FleetCart\Scaffold\Module\ModuleScaffold;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class ScaffoldModuleCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'scaffold:module';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scaffold a new module';

    /**
     * The instance of ModuleScaffold.
     *
     * @var ModuleScaffold
     */
    private ModuleScaffold $scaffolder;


    /**
     * Create a new command instance.
     *
     * @param ModuleScaffold $scaffolder
     */
    public function __construct(ModuleScaffold $scaffolder)
    {
        parent::__construct();

        $this->scaffolder = $scaffolder;
    }


    /**
     * Execute the console command.
     *
     * @return void
     * @throws FileNotFoundException
     */
    public function handle(): void
    {
        $module = $this->askModuleName();
        $entities = $this->askEntities();

        $this->scaffolder->scaffold($module, $entities);

        $this->info('Module has been generated.');
    }


    /**
     * Ask for module name.
     *
     * @return array
     */
    private function askModuleName(): array
    {
        do {
            do {
                $moduleName = $this->ask('Please enter the module name in the following format: vendor/name');
            } while (!$this->moduleNameIsValid($moduleName));

            [$vendor, $name] = $this->extractModuleName($moduleName);
        } while ($this->moduleExists($name));

        return compact('vendor', 'name');
    }


    /**
     * Validate the given module name.
     *
     * @param string $moduleName
     *
     * @return bool
     */
    private function moduleNameIsValid(string $moduleName): bool
    {
        $name = explode('/', $moduleName);

        if (count($name) !== 2) {
            $this->error('Module name must be in the following format: vendor/name');

            return false;
        }

        return true;
    }


    /**
     * Extract the given module name.
     *
     * @param string $moduleName
     *
     * @return array
     */
    private function extractModuleName(string $moduleName): array
    {
        $name = explode('/', $moduleName);

        return [$name[0], ucfirst(camel_case($name[1]))];
    }


    /**
     * Determine the given module is exists.
     *
     * @param string $name
     */
    private function moduleExists($name): bool
    {
        if (is_dir(config('modules.paths.modules') . "/{$name}")) {
            $this->error("The module [$name] is already exists.");

            return true;
        }

        return false;
    }


    /**
     * Ask for entities.
     *
     * @return array
     */
    private function askEntities(): array
    {
        $entities = [];

        do {
            $entity = $this->ask('Enter entity name. To Continue Press Enter .', false);

            if ($entity !== '') {
                $entities[] = ucfirst($entity);
            }
        } while ($entity !== '');

        return $entities;
    }
}
