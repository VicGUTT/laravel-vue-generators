<?php

namespace VueGenerators\Commands;

use VueGenerators\Paths;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use VueGenerators\Exceptions\ResourceAlreadyExists;

class VueGeneratorsCommand extends Command
{
    use Paths;

    /**
     * Create path for file.
     *
     * @param Filesystem $filesystem
     * @param string     $type       File type.
     *
     * @return string
     */
    protected function createPath(Filesystem $filesystem, $type)
    {
        $customPath = $this->option('path');

        if (config("vue-generators.paths.{$type}s")) {
            $defaultPath = config("vue-generators.paths.{$type}s");
        } else {
            $paths       = $filesystem->getRequire(base_path('vendor/zachleigh/laravel-vue-generators/src/config.php'));
            $defaultPath = $paths['paths'][$type . 's'];
        }

        $path = $customPath !== null ? $customPath : $defaultPath;

        $this->buildPathFromArray($path, $filesystem);

        return $path;
    }

    protected function checkFileExists(Filesystem $filesystem, $path, $name)
    {
        if ($filesystem->exists($path)) {
            throw ResourceAlreadyExists::fileExists($name);
        }
    }
}
