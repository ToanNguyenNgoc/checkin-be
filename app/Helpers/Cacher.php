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

    public static function setRedis($prefix, $id, $data, $expirationMinutes = null)
    {
        $key = "{$prefix}_{$id}";
        $data = json_encode($data);

        if ($expirationMinutes) {
            Redis::setex($key, $expirationMinutes*60, $data);
        } else {
            Redis::set($key, $data);
        }

        return true;
    }

    public static function updateRedis($prefix, $id, $data, $expirationMinutes = null)
    {
        $data = json_encode($data);
        self::deleteRedis($prefix, $id);
        self::setRedis($prefix, $id, $data, $expirationMinutes);
        return true;
    }

    public static function deleteRedis($prefix, $id)
    {
        $key = "{$prefix}_{$id}";
        Redis::del($key);
        return true;
    }

    private function return($result, $type)
    {
        switch ($type) {
            case "json":
                return json_decode($result, FALSE);
            case "array":
                return json_decode($result, FALSE);
            default:
                /* raw */
                return $result;
        }

        return null;
    }
}
