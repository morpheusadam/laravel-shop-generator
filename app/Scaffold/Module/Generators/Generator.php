<?php

namespace FleetCart\Scaffold\Module\Generators;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

abstract class Generator
{
    /**
     * The instance of Filesystem.
     *
     * @var Filesystem
     */
    protected Filesystem $finder;

    /**
     * Name of the module.
     *
     * @var string
     */
    protected string $name;


    /**
     * Create a new instance.
     *
     * @param Filesystem $finder
     */
    public function __construct(Filesystem $finder)
    {
        $this->finder = $finder;
    }


    /**
     * Generate the given files.
     *
     * @param array $files
     *
     * @return void
     */
    abstract public function generate(array $files): void;


    /**
     * Set the module name.
     *
     * @param string $name
     *
     * @return $this
     */
    public function module(string $name): static
    {
        $this->name = ucfirst($name);

        return $this;
    }


    /**
     * Create directory if not exists.
     *
     * @param string $path
     *
     * @return string
     */
    protected function createDirectory($path): string
    {
        $path = $this->getModulesPath($path);

        if (!$this->finder->isDirectory($path)) {
            $this->finder->makeDirectory($path, 0755, true);
        }

        return $path;
    }


    /**
     * Return the current module path.
     *
     * @param string $path
     *
     * @return string
     */
    protected function getModulesPath(string $path = ''): string
    {
        return config('modules.paths.modules') . "/{$this->name}/{$path}";
    }


    /**
     * Get content of the given stub.
     *
     * @param string $stub
     * @param string $class
     *
     * @return string
     * @throws FileNotFoundException
     */
    protected function getContentForStub(string $stub, string $class = ''): string
    {
        $stub = $this->finder->get($this->getStubPath($stub));

        return str_replace([
            '$MODULE_NAME$',
            '$LOWERCASE_MODULE_NAME$',
            '$LCFIRST_ENTITY_NAME$',
            '$ENTITY_NAME$',
            '$LOWERCASE_ENTITY_NAME$',
            '$TITLE_CASE_ENTITY_NAME$',
            '$SNAKE_CASE_ENTITY_NAME$',
            '$KEBAB_CASE_ENTITY_NAME$',
            '$PLURAL_ENTITY_NAME$',
            '$PLURAL_LOWERCASE_ENTITY_NAME$',
            '$PLURAL_TITLE_CASE_ENTITY_NAME$',
            '$PLURAL_SNAKE_CASE_ENTITY_NAME$',
            '$PLURAL_KEBAB_CASE_ENTITY_NAME$',
        ], [
            $this->name,
            strtolower($this->name),
            lcfirst($class),
            $class,
            strtolower($class),
            title_case(str_replace('_', ' ', snake_case($class))),
            snake_case($class),
            kebab_case($class),
            str_plural($class),
            str_plural(strtolower($class)),
            title_case(str_replace('_', ' ', snake_case(str_plural($class)))),
            snake_case(str_plural($class)),
            kebab_case(str_plural($class)),
        ], $stub);
    }


    /**
     * Get stub path for the given stub file.
     *
     * @param string $filename
     *
     * @return string
     */
    protected function getStubPath($filename)
    {
        return __DIR__ . "/../stubs/{$filename}";
    }
}
