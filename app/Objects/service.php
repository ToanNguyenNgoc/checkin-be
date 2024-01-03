<?php
namespace App\Services--ServiceNameSpace--;

use App\Models\--ModelName--;
use App\Repositories--RepoPath--;
use App\Services\BaseService;

class --ServiceName-- extends BaseService
{
    public function __construct()
    {
        $this->repo = new --RepoName--();
    }
}
