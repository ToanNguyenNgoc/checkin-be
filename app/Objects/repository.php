<?php
namespace App\Repositories\--ModelName--;

use App\Repositories\Repository;

class --RepoName-- extends Repository implements --RepoInterfaceName--
{
    public function getModel()
    {
        return \App\Models\--ModelName--::class;
    }
}
