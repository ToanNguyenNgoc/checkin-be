<?php

namespace App\Console\Commands\Libs;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class GenerateObject extends Command
{
    private $appPath;
    private $objectPath;
    private $modelName;
    private $options;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:object {modelName} {--pathName=} {--isNotController}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate object {modelName} {--pathName=} {--isNotController}';

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

        $this->modelName = $this->argument('modelName');
        $this->options = (object)$this->options();

        if (!File::exists($this->objectPath)) {
            $this->error("!!! Objects directory not found");
            return false;
        }

        if (!$this->options->isNotController) {
            $this->generateController();
        }

        $this->generateService();
        $this->generateRepository();

        $this->info("Resources for model {$this->modelName} generated successfully!");
        return true;
    }

    protected function generateController()
    {
        $controllerPath = "{$this->appPath}/Http/Controllers";

        if (!empty($this->options->pathName)) {
            $controllerPath = "{$controllerPath}/{$this->options->pathName}";
            $servicePath = "\\{$this->options->pathName}\\{$this->modelName}Service";
            $controllerNameSpace = "\\{$this->options->pathName}";
        } else {
            $servicePath = "\\{$this->modelName}Service";
            $controllerNameSpace = "";
        }

        if (!File::exists($controllerPath)) {
            File::makeDirectory($controllerPath);
        }

        /* Copy file from Objects to Controllers */
        $controllerFile = "{$this->objectPath}/controller.php";
        $desControllerFile = "{$controllerPath}/{$this->modelName}Controller.php";
        File::copy($controllerFile, $desControllerFile);

        /* Edit controller */
        if (File::exists($desControllerFile)) {
            $content = File::get($desControllerFile);
            $controllerName = "{$this->modelName}Controller";
            $serviceName = "{$this->modelName}Service";

            $content = str_replace('--ControllerPath--', $controllerNameSpace, $content);
            $content = str_replace('--ControllerName--', $controllerName, $content);
            $content = str_replace('--ServicePath--', $servicePath, $content);
            $content = str_replace('--ServiceName--', $serviceName, $content);
            $content = str_replace('--ModelName--', $this->modelName, $content);

            /* Write new controller file */
            File::put($desControllerFile, $content);
        }
    }

    protected function generateService()
    {
        $servicePath = "{$this->appPath}/Services";

        if (!empty($this->options->pathName)) {
            $servicePath = "{$servicePath}/{$this->options->pathName}";
            $serviceNameSpace = "\\{$this->options->pathName}";
        } else {
            $serviceNameSpace = "";
        }

        if (!File::exists($servicePath)) {
            File::makeDirectory($servicePath);
        }

        /* Copy file from Objects to Services */
        $serviceFile = "{$this->objectPath}/service.php";
        $desServiceFile = "{$servicePath}/{$this->modelName}Service.php";
        File::copy($serviceFile, $desServiceFile);

        /* Edit service */
        if (File::exists($desServiceFile)) {
            $content = File::get($desServiceFile);
            $serviceName = "{$this->modelName}Service";
            $repoPath = "\\{$this->modelName}\\{$this->modelName}Repository";
            $repoName = "{$this->modelName}Repository";

            $content = str_replace('--ServiceNameSpace--', $serviceNameSpace, $content);
            $content = str_replace('--ModelName--', $this->modelName, $content);
            $content = str_replace('--RepoPath--', $repoPath, $content);
            $content = str_replace('--ServiceName--', $serviceName, $content);
            $content = str_replace('--RepoName--', $repoName, $content);

            /* Write new service file */
            File::put($desServiceFile, $content);
        }
    }

    protected function generateRepository()
    {
        $repoPath = "{$this->appPath}/Repositories/{$this->modelName}";

        if (!File::exists($repoPath)) {
            File::makeDirectory($repoPath);
        }

        /* Copy file from Objects to Repository Interface */
        $repoInterfaceFile = "{$this->objectPath}/repositoryinterface.php";
        $desRepoInterfaceFile = "{$repoPath}/{$this->modelName}RepositoryInterface.php";
        File::copy($repoInterfaceFile, $desRepoInterfaceFile);

        /* Edit RepositoryInterface */
        if (File::exists($desRepoInterfaceFile)) {
            $content = File::get($desRepoInterfaceFile);
            $repoInterfaceName = "{$this->modelName}RepositoryInterface";

            $content = str_replace('--ModelName--', $this->modelName, $content);
            $content = str_replace('--RepoInterfaceName--', $repoInterfaceName, $content);

            /* Write new repository interface file */
            File::put($desRepoInterfaceFile, $content);
        }

        /* Copy file from Objects to Repository */
        $repoFile = "{$this->objectPath}/repository.php";
        $desRepoFile = "{$repoPath}/{$this->modelName}Repository.php";
        File::copy($repoFile, $desRepoFile);

        /* Edit Repository */
        if (File::exists($desRepoFile)) {
            $content = File::get($desRepoFile);
            $repoName = "{$this->modelName}Repository";
            $repoInterfaceName = "{$this->modelName}RepositoryInterface";

            $content = str_replace('--ModelName--', $this->modelName, $content);
            $content = str_replace('--RepoName--', $repoName, $content);
            $content = str_replace('--RepoInterfaceName--', $repoInterfaceName, $content);

            /* Write new repository interface file */
            File::put($desRepoFile, $content);
        }
    }
}
