<?php

namespace WeMiniGrade\Api;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class Log
{
    private static $handler;

    public static function init($config = [])
    {
        if($config){
            $log_file = $config['log_path'].'/'.date('Ymd').'.log';
            self::$handler = new Logger('wechatmini_grade');
            self::$handler->pushHandler(new StreamHandler($log_file, Logger::DEBUG));
        }
    }

    public static function record($message = '', $type = 'debug')
    {
        if(is_object(self::$handler)){
            self::$handler->$type($message);
        }
    }

    public static function debug($message = '')
    {
        self::record($message, 'debug');
    }

    public static function info($message = '')
    {
        self::record($message, 'debug');
    }

    public static function warning($message = '')
    {
        self::record($message, 'debug');
    }

    public static function error($message = '')
    {
        self::record($message, 'debug');
    }
}