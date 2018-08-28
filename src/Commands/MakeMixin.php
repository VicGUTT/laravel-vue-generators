<?php

namespace VueGenerators\Commands;

use Illuminate\Filesystem\Filesystem;

class MakeMixin extends VueGeneratorsCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vue:mixin {name} {--empty} {--simple} {--path=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Vue.js mixin file.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $filesystem = new Filesystem();
        
        $name       = $this->argument('name').'.js';
        
        $path       = $this->createPath($filesystem, 'mixin');
        
        $fullPath   = base_path("{$path}/{$name}");
        
        $this->checkFileExists($filesystem, $fullPath, $name);
        
        $stub       = $this->getStub($filesystem);

        $filesystem->put($fullPath, $stub);

        $this->info("Mixin {$name} succesfully created.");
    }

    /**
     * Get and return stub.
     *
     * @param Filesystem $filesystem
     *
     * @return string
     */
    protected function getStub(Filesystem $filesystem)
    {
        $fileName = ucfirst($this->option('empty') ? 'empty' : ($this->option('simple') ? 'simple' : '')) . 'Mixin';

        return $filesystem->get(__DIR__.'/../Stubs/'.$fileName.'.js');
    }
}
