<?php

namespace App\Console\Commands\Libs;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class GenerateRequestValidation extends Command
{
    private $appPath;
    private $objectPath;
    private $requestName;
    private $options;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:request {requestName} {--pathName=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate request {requestName} {--pathName=}';

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

        $this->requestName = $this->argument('requestName');
        $this->options = (object)$this->options();

        if (!File::exists($this->objectPath)) {
            $this->error("!!! Objects directory not found");
            return false;
        }

        $this->generateRequest();
        $this->info("{$this->requestName}Request generated successfully!");
        return true;
    }

    protected function generateRequest()
    {
        $requestPath = "{$this->appPath}/Http/Requests";

        if (!empty($this->options->pathName)) {
            $requestPath = "{$requestPath}/{$this->options->pathName}";
            $requestNameSpace = "\\".str_replace('/', '\\', $this->options->pathName);
        } else {
            $requestNameSpace = "";
        }

        if (!File::exists($requestPath)) {
            File::makeDirectory($requestPath);
        }

        /* Copy file from Objects to Requests */
        $requestFile = "{$this->objectPath}/request.php";
        $desRequestFile = "{$requestPath}/{$this->requestName}Request.php";
        File::copy($requestFile, $desRequestFile);

        /* Edit controller */
        if (File::exists($desRequestFile)) {
            $content = File::get($desRequestFile);
            $requestName = "{$this->requestName}Request";

            $content = str_replace('--RequestPath--', $requestNameSpace, $content);
            $content = str_replace('--RequestName--', $requestName, $content);

            /* Write new controller file */
            File::put($desRequestFile, $content);
        }
    }
}
