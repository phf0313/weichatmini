<?php

namespace WeMiniGrade\Api;

use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\Adapter\RedisAdapter;

class WeMiniCache
{
    private static $cacheDir;
    private static $cacheTime;
    private static $cacheType;

    private static $cache;

    public static function init($config = [])
    {
        if(!isset($config['cache_type'])){
            self::$cacheType = 'file';
        }else{
            self::$cacheType = $config['cache_type'];
        }
        self::$cacheTime = $config['cache_time']??800;

        switch (self::$cacheType){
            case 'file':
                self::$cacheDir = $config['cache_dir'];
                self::$cache = new FilesystemAdapter($config['namespace'], self::$cacheTime, self::$cacheDir);
                break;
            case 'redis':
                self::$cache = new RedisAdapter(
                    RedisAdapter::createConnection('redis://'.$config['cache_redis_host']),
                    $config['namespace'],
                    self::$cacheTime
                );
                break;
        }

    }

    public static function get($key, $default = '')
    {
        $item = self::$cache->getItem($key);
        if($item->isHit()){
            return $item->get();
        }else{
            return $default;
        }
    }

    public static function set($key, $value, $time = false)
    {
        $item = self::$cache->getItem($key);

        $item->set($value);
        if($time){
            $item->expiresAfter($time);
        }
        return self::$cache->save($item);
    }


}