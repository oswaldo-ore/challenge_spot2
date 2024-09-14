<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MakeRepository extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new repository class';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $name = $this->argument('name');
        $path = app_path('Repositories/' . $name . '.php');

        if (file_exists($path)) {
            $this->error('Repository already exists!');
            return;
        }

        makeDirectory($path);

        $stub = $this->compileStub($name);

        file_put_contents($path, $stub);

        $this->info('Repository created successfully.');
    }

    protected function makeRepository($name, $path)
    {
        $directory = dirname($path);
        if(!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }
    }

    protected function compileStub($name)
    {
        $stub = file_get_contents(resource_path('stubs/repository.stub'));
        return str_replace('{{class}}', $name, $stub);
    }
}
