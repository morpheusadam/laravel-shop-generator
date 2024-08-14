<?php

namespace FleetCart\Scaffold\Module\Generators;

use Illuminate\Contracts\Filesystem\FileNotFoundException;

class FilesGenerator extends Generator
{
    /**
     * Generate the given files.
     *
     * @param array $files
     *
     * @return void
     * @throws FileNotFoundException
     */
    public function generate(array $files): void
    {
        foreach ($files as $stub => $file) {
            $this->finder->put(
                $this->getModulesPath($file),
                $this->getContentFor($stub)
            );
        }
    }


    /**
     * Generate the base module service provider.
     *
     * @return void
     * @throws FileNotFoundException
     */
    public function generateModuleServiceProvider(): void
    {
        $this->finder->put(
            $this->getModulesPath("Providers/{$this->name}ServiceProvider.php"),
            $this->getContentFor('providers/module-service-provider.stub')
        );
    }


    /**
     * Get the content for the given file.
     *
     * @param string $stub
     *
     * @return string
     *
     * @throws FileNotFoundException
     */
    private function getContentFor(string $stub): string
    {
        $stub = $this->finder->get($this->getStubPath($stub));

        return str_replace(
            ['$MODULE$', '$LOWERCASE_MODULE$', '$PLURAL_MODULE$', '$UPPERCASE_PLURAL_MODULE$'],
            [$this->name, strtolower($this->name), strtolower(str_plural($this->name)), str_plural($this->name)],
            $stub
        );
    }
}
