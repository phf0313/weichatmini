<?php

namespace WeMiniGrade\Api;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class Log
{
    private static $handler;

    public static function init($config = [])
    {
        $log_file = $config['log_path'].'/'.date('Ymd').'.log';
        self::$handler = new Logger('wechatmini_grade');
        self::$handler->pushHandler(new StreamHandler($log_file, Logger::DEBUG));
    }

    public static function record($message = '', $type = 'debug')
    {
        self::$handler->$type($message);
    }

    public static function debug($message = '')
    {
        self::$handler->debug($message);
    }

    public static function info($message = '')
    {
        self::$handler->info($message);
    }

    public static function warning($message = '')
    {
        self::$handler->waring($message);
    }

    public static function error($message = '')
    {
        self::$handler->error($message);
    }
}