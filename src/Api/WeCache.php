<?php

namespace phf0313\WechatMini\Api;

class WeCache
{
    private static $cacheDir;
    private static $cacheFile;
    private static $cacheTime;
    private static $cacheInitFile;

    public static function init($cache_dir, $cache_time = 600)
    {
        self::$cacheDir = $cache_dir;
        self::$cacheTime = $cache_time;
        self::$cacheFile = self::$cacheInitFile = $cache_dir . '/cache';
    }

    /**
     * 设置超时时间
     * @param int $cache_time
     */
    public static function setTime($cache_time = 600)
    {
        self::$cacheTime = $cache_time;
    }

    public static function get($key, $default = '')
    {
        $data = self::readAndRender($key);
        self::checkTimeoutAndSave($data);

        if (isset($data[$key])) {
            return $data[$key]['value'];
        } else {
            return $default;
        }
    }

    public static function set($key, $value, $time = false)
    {
        if (!$time) $time = self::$cacheTime;

        $data = self::readAndRender($key);

        $data[$key] = ['value' => $value, 'time' => time() + $time];

        return self::checkTimeoutAndSave($data);
    }

    private static function readAndRender($key)
    {
        if (!is_dir(self::$cacheDir)) {
            mkdir(self::$cacheDir);
        }

        if(self::$cacheFile === self::$cacheInitFile){
            self::$cacheFile .= '_'.$key;
        }

        if (file_exists(self::$cacheFile)) {
            $json = file_get_contents(self::$cacheFile);
            $data = json_decode($json, true);
            if (!is_array($data)) {
                $data = [];
            }
        } else {
            $data = [];
        }

        return $data;
    }

    private static function checkTimeoutAndSave(&$data)
    {
        $cur_time = time();
        foreach ($data as $k => $v) {
            if ($cur_time > $data[$k]['time']) {
                unset($data[$k]);
            }
        }

        $content = json_encode($data);
        if (file_put_contents(self::$cacheFile, $content)) {
            self::$cacheFile = self::$cacheInitFile;
            return true;
        } else {
            return false;
        }
    }
}