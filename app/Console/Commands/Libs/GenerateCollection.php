<?php

namespace App\Console\Commands\Libs;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class GenerateCollection extends Command
{
    private $appPath;
    private $objectPath;
    private $collectionName;
    private $options;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:collection {collectionName} {--pathName=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate collection {collectionName} {--pathName=}';

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

        $this->collectionName = $this->argument('collectionName');
        $this->options = (object)$this->options();

        if (!File::exists($this->objectPath)) {
            $this->error("!!! Objects directory not found");
            return false;
        }

        $this->generateCollection();
        $this->info("{$this->collectionName}Collection generated successfully!");
        return true;
    }

    protected function generateCollection()
    {
        $collectionPath = "{$this->appPath}/Http/Resources";

        if (!empty($this->options->pathName)) {
            $collectionPath = "{$collectionPath}/{$this->options->pathName}";
            $collectionNameSpace = "\\".str_replace('/', '\\', $this->options->pathName);
        } else {
            $collectionNameSpace = "";
        }

        if (!File::exists($collectionPath)) {
            File::makeDirectory($collectionPath);
        }

        /* Copy file from Objects to Collections */
        $collectionFile = "{$this->objectPath}/collection.php";
        $desCollectionFile = "{$collectionPath}/{$this->collectionName}Collection.php";
        File::copy($collectionFile, $desCollectionFile);

        /* Edit controller */
        if (File::exists($desCollectionFile)) {
            $content = File::get($desCollectionFile);
            $collectionName = "{$this->collectionName}Collection";

            $content = str_replace('--CollectionPath--', $collectionNameSpace, $content);
            $content = str_replace('--CollectionName--', $collectionName, $content);

            /* Write new controller file */
            File::put($desCollectionFile, $content);
        }
    }
}
