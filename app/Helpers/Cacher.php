<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Redis;

class Cacher
{
    public static function getRedis($prefix, $id, $returnType = "json")
    {
        $cache = Redis::get("{$prefix}_{$id}");
        return self::return($cache, $returnType);
    }

    public static function setRedis($prefix, $id)
    {

    }

    public static function updateRedis($prefix, $id)
    {

    }

    private function return($result, $type)
    {
        switch ($type) {
            case "json":
                return json_decode($result, FALSE);
            case "array":
                return json_decode($result, FALSE);
            default:
                return $result;
        }

        return null;
    }
}
