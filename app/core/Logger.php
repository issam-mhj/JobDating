<?php

namespace App\Core;

class Logger
{
    private static $cache = [];
    private static $cacheLimit = 10;
    private static $flushInterval = 10;
    private static $firstLogTime = null;
    private static $logFile = __DIR__ . '/../../app.log';
    private static $logLevel = 'debug';

    public static function setLogFile($file)
    {
        self::$logFile = $file;
    }

    public static function setLogLevel($level)
    {
        self::$logLevel = $level;
    }

    public static function getFlushInterval()
    {
        return self::$flushInterval;
    }

    public static function getFirstLogTime()
    {
        return self::$firstLogTime;
    }

    public static function log($message, $level = 'INFO')
    {

        if (strtolower(self::$logLevel) === 'debug' || strtolower(self::$logLevel) === strtolower($level)) {
            self::addToCache($message, $level);
        }
    }

    public static function error($message)
    {
        self::log($message, 'ERROR');
    }

    private static function addToCache($message, $level)
    {
        if (empty(self::$cache)) {
            self::$firstLogTime = time();
        }

        self::$cache[] = date('Y-m-d H:i:s') . ' - ' . strtoupper($level) . ' - ' . $message;

        $currentTime = time();
       
        if (count(self::$cache) >= self::$cacheLimit || ($currentTime - self::$firstLogTime) >= self::$flushInterval) {
            self::flush();
        }
    }

    public static function flush()
    {
        if (!empty(self::$cache)) {
            $formattedMessage = implode(PHP_EOL, self::$cache) . PHP_EOL;
            file_put_contents(self::$logFile, $formattedMessage, FILE_APPEND);
            self::$cache = [];
            self::$firstLogTime = null;
        }
    }
}

register_shutdown_function(function () {
    $firstLogTime = Logger::getFirstLogTime();
    if ($firstLogTime !== null) {
        $elapsed = time() - $firstLogTime;
        $flushInterval = Logger::getFlushInterval();
        if ($elapsed < $flushInterval) {
            sleep($flushInterval - $elapsed);
        }
    }
    Logger::flush();
});
