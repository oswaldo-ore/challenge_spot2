<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MakeService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {name} {--repositories=*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new service class with optional repositories';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $name = $this->argument('name');
        $nameRepository = preg_replace('/Service\w*/i', 'Repository', $name);
        $repositories = $this->option('repositories') ?: ['App\Repositories\\' . $nameRepository];

        $path = app_path("Services/{$name}.php");

        if (file_exists($path)) {
            $this->error('Service already exists!');
            return;
        }

        makeDirectory($path);

        $stub = $this->compileStub($name, $repositories);

        file_put_contents($path, $stub);

        $this->info('Service created successfully.');
    }

    protected function compileStub($name, $repositories)
    {
        $stub = file_get_contents(resource_path('stubs/service.stub'));

        $useStatements = '';
        $constructorParameters = '';
        $constructorAssignments = '';

        foreach ($repositories as $repository) {
            $className = class_basename($repository);
            $useStatements .= "use {$repository};\n";
            $lowerCaseParam = lcfirst(ucwords($className));
            $constructorParameters .= "{$className} \${$lowerCaseParam}, ";
            $constructorAssignments .= "\$this->{$lowerCaseParam} = \${$lowerCaseParam};\n";
        }
        $constructorParameters = rtrim($constructorParameters, ', ');

        $stub = str_replace(
            ['{{name}}', '{{useStatements}}', '{{constructorParameters}}', '{{constructorAssignments}}'],
            [$name, $useStatements, $constructorParameters, $constructorAssignments],
            $stub
        );

        return $stub;
    }
}
