<?php

namespace FleetCart\Scaffold\Module;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Artisan;
use FleetCart\Scaffold\Module\Generators\FilesGenerator;
use FleetCart\Scaffold\Module\Generators\EntityGenerator;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class ModuleScaffold
{
    /**
     * The vendor name of the module.
     *
     * @var string
     */
    protected string $vendor;

    /**
     * The module name which will be generated.
     *
     * @var string
     */
    protected string $name;
    /**
     * Array of files to be generated.
     *
     * @var array
     */
    protected array $stubsToFilesMap = [
        'config/permissions.stub' => 'Config/permissions.php',
        'routes/routes.stub' => 'Routes/admin.php',
    ];
    /**
     * The instance of Filesystem.
     *
     * @var Filesystem
     */
    private Filesystem $finder;
    /**
     * The instance of EntityGenerator.
     *
     * @var EntityGenerator
     */
    private EntityGenerator $entityGenerator;
    /**
     * The instance of FilesGenerator.
     *
     * @var FilesGenerator
     */
    private FilesGenerator $filesGenerator;


    /**
     * Create a new instance.
     *
     * @param Filesystem $finder
     * @param EntityGenerator $entityGenerator
     * @param FilesGenerator $filesGenerator
     */
    public function __construct(Filesystem $finder, EntityGenerator $entityGenerator, FilesGenerator $filesGenerator)
    {
        $this->finder = $finder;
        $this->entityGenerator = $entityGenerator;
        $this->filesGenerator = $filesGenerator;
    }


    /**
     * @param array $module
     * @param array $entities
     *
     * @return void
     * @throws FileNotFoundException
     */
    public function scaffold(array $module, array $entities): void
    {
        $this->vendor = $module['vendor'];
        $this->name = $module['name'];



        $this->generateModule();
        $this->renameVendorName();
        $this->addFolders();
        $this->removeUnneededFilesAndFolders();
        $this->modifyComposerJsonFile();

        $this->filesGenerator->module($this->name)->generateModuleServiceProvider();
        $this->filesGenerator->module($this->name)->generate($this->stubsToFilesMap);

        $this->modifyModuleJsonFile();
        $this->cleanupModuleJsonFile();

        $this->entityGenerator->module($this->getName())->generate($entities);
    }


    /**
     * Generate default module.
     *
     * @return void
     */
    public function generateModule(): void
    {
        Artisan::call('module:make', ['name' => [$this->name]]);
    }


    /**
     * Get studly cased module name.
     *
     * @return string
     */
    public function getName(): string
    {
        return studly_case($this->name);
    }


    /**
     * Remove vendor name from composer.json file.
     *
     * @return void
     * @throws FileNotFoundException
     */
    private function renameVendorName(): void
    {
        $composerJsonPath = $this->getModulesPath('composer.json');
        $composerJsonContent = $this->finder->get($composerJsonPath);
        $composerJsonContent = str_replace('nwidart', $this->vendor, $composerJsonContent);

        $this->finder->put($composerJsonPath, $composerJsonContent);
    }


    /**
     * Get the path on the module.
     *
     * @param string $path
     *
     * @return string
     */
    private function getModulesPath(string $path = ''): string
    {
        return config('modules.paths.modules') . "/{$this->getName()}/{$path}";
    }


    /**
     * Add required folders.
     *
     * @return void
     */
    private function addFolders(): void
    {
        $this->addSidebarFolder();
    }


    /**
     * Add Sidebar folder.
     *
     * @return void
     */
    private function addSidebarFolder(): void
    {
        $directoryPath = $this->getModulesPath('Sidebar');
        $this->finder->makeDirectory($directoryPath);
    }


    /**
     * Remove unneeded files and folders.
     *
     * @return void
     */
    private function removeUnneededFilesAndFolders(): void
    {
        $this->removeUnneededFiles();
        $this->removeUnneededFolders();
    }


    /**
     * Remove unneeded files.
     *
     * @return void
     */
    private function removeUnneededFiles(): void
    {
        $files = $this->getModulesPaths([
            'Config/.gitkeep',
            'Config/config.php',
            'Entities/.gitkeep',
            'Database/Migrations/.gitkeep',
            'Http/Controllers/.gitkeep',
            'Http/Requests/.gitkeep',
            "Http/Controllers/{$this->name}Controller.php",
            'Providers/.gitkeep',
            'Providers/RouteServiceProvider.php',
            'Resources/lang/.gitkeep',
            'Resources/views/.gitkeep',
            'Resources/views/index.blade.php',
            'Resources/views/layouts/master.blade.php',
            'Routes/.gitkeep',
            'Routes/web.php',
            'Routes/api.php',
            'package.json',
            'webpack.mix.js',
        ]);

        $this->finder->delete($files);
    }


    /**
     * Get the paths on the module.
     *
     * @param array $paths
     *
     * @return array
     */
    private function getModulesPaths(array $paths): array
    {
        $list = [];

        foreach ($paths as $path) {
            $list[] = $this->getModulesPath($path);
        }

        return $list;
    }


    /**
     * Remove unneeded folders.
     *
     * @return void
     */
    private function removeUnneededFolders(): void
    {
        $this->finder->deleteDirectory($this->getModulesPath('Database/factories'));
        $this->finder->deleteDirectory($this->getModulesPath('Database/Seeders'));
        $this->finder->deleteDirectory($this->getModulesPath('Events'));
        $this->finder->deleteDirectory($this->getModulesPath('Console'));
        $this->finder->deleteDirectory($this->getModulesPath('Http/Middleware'));
        $this->finder->deleteDirectory($this->getModulesPath('Jobs'));
        $this->finder->deleteDirectory($this->getModulesPath('Mail'));
        $this->finder->deleteDirectory($this->getModulesPath('Resources/assets'));
        $this->finder->deleteDirectory($this->getModulesPath('Resources/views/layouts'));
        $this->finder->deleteDirectory($this->getModulesPath('Tests'));
    }


    /**
     * Add data to composer.json file.
     *
     * @return void
     * @throws FileNotFoundException
     */
    private function modifyComposerJsonFile(): void
    {
        $moduleName = ucfirst($this->name);
        $composerJsonPath = $this->getModulesPath('composer.json');

        $composerJsonFile = fopen($composerJsonPath, "r");

        $composerJsonFileAsArray = [];
        while (!feof($composerJsonFile)) {
            $composerJsonFileAsArray[] = rtrim(fgets($composerJsonFile));
        }

        $composerJsonText = '';

        foreach ($composerJsonFileAsArray as $lineNumber => $textLine) {
            if ($lineNumber === 2) {
                $composerJsonText .= "    \"description\": \"The FleetCart {$moduleName} Module.\"," . PHP_EOL;
                continue;
            } else if ($lineNumber >= 9 && $lineNumber <= 23) {
                continue;
            }

            $composerJsonText .= $textLine . PHP_EOL;
        }

        $search = <<<JSON
],
JSON;

        $replace = <<<JSON
],
    "require": {
        "php": ">=8.1.0"
    },
    "autoload": {
        "psr-4": {
            "Modules\\\\{$moduleName}\\\\": ""
        }
    },
    "extra": {
        "branch-alias": {
            "dev-master": "1.0.x-dev"
        }
    },
    "config": {
        "sort-packages": true
    },
    "minimum-stability": "dev"
}
JSON;

        $composerJson = str_replace($search, $replace, $composerJsonText);

        $this->finder->put($this->getModulesPath('composer.json'), $composerJson);
    }


    /**
     * Add data to module.json file.
     *
     * @return void
     * @throws FileNotFoundException
     */
    private function modifyModuleJsonFile(): void
    {
        $moduleJson = $this->finder->get($this->getModulesPath('module.json'));
dump($moduleJson);
        $moduleJson = $this->setModulePriority($moduleJson);
dump($moduleJson);
        $this->finder->put($this->getModulesPath('module.json'), $moduleJson);
    }


    /**
     * Set the module priority for composer.json file.
     *
     * @param $content
     *
     * @return string
     */
    private function setModulePriority($content): string
    {
        return str_replace('"priority": 0,', '"priority": 100,', $content);
    }


    /**
     * Remove unneeded data from module.json file.
     *
     * @return void
     * @throws FileNotFoundException
     */
    private function cleanupModuleJsonFile(): void
    {
        $moduleJson = $this->finder->get($this->getModulesPath('module.json'));

        $moduleName = ucfirst($this->name);

        // Update module description.
        $search = <<<JSON
"description": "",
JSON;

        $replace = <<<JSON
"description": "The FleetCart {$moduleName} Module.",
JSON;

        $moduleJson = str_replace($search, $replace, $moduleJson);

        // Remove unneeded nodes.
        $search = <<<JSON
],
    "aliases": {},
    "files": [],
    "requires": []
JSON;

        $moduleJson = str_replace($search, ']', $moduleJson);

        $this->finder->put($this->getModulesPath('module.json'), $moduleJson);
    }
}
