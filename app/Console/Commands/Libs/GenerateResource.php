<?php

namespace App\Console\Commands\Libs;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class GenerateResource extends Command
{
    private $appPath;
    private $objectPath;
    private $resourceName;
    private $options;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:resource {resourceName} {--pathName=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate resource {resourceName} {--pathName=}';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->generateObject();
        return Command::SUCCESS;
    }

    protected function generateObject()
    {
        $this->appPath = app_path();
        $this->objectPath = "$this->appPath/Objects";

        $this->resourceName = $this->argument('resourceName');
        $this->options = (object)$this->options();

        if (!File::exists($this->objectPath)) {
            $this->error("!!! Objects directory not found");
            return false;
        }

        $this->generateResource();
        $this->info("{$this->resourceName}Resource generated successfully!");
        return true;
    }

    protected function generateResource()
    {
        $resourcePath = "{$this->appPath}/Http/Resources";

        if (!empty($this->options->pathName)) {
            $resourcePath = "{$resourcePath}/{$this->options->pathName}";
            $resourceNameSpace = "\\".str_replace('/', '\\', $this->options->pathName);
        } else {
            $resourceNameSpace = "";
        }

        if (!File::exists($resourcePath)) {
            File::makeDirectory($resourcePath);
        }

        /* Copy file from Objects to Resources */
        $resourceFile = "{$this->objectPath}/resource.php";
        $desResourceFile = "{$resourcePath}/{$this->resourceName}Resource.php";
        File::copy($resourceFile, $desResourceFile);

        /* Edit controller */
        if (File::exists($desResourceFile)) {
            $content = File::get($desResourceFile);
            $resourceName = "{$this->resourceName}Resource";

            $content = str_replace('--ResourcePath--', $resourceNameSpace, $content);
            $content = str_replace('--ResourceName--', $resourceName, $content);

            /* Write new controller file */
            File::put($desResourceFile, $content);
        }
    }
}
