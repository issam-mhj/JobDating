<?php

namespace App\Core;

use App\Core\Logger;
use Illuminate\Database\Capsule\Manager as Capsule;

class Database
{
    public static function init()
    {
        try {
            $capsule = new Capsule;
            $capsule->addConnection([
                'driver' => $_ENV['DB_DRIVER'] ?? 'mysql',
                'host' => $_ENV['DB_HOST'],
                'database' => $_ENV['DB_NAME'],
                'username' => $_ENV['DB_USER'],
                'password' => $_ENV['DB_PASSWORD'],
            ]);

            $capsule->setAsGlobal();
            $capsule->bootEloquent();
        } catch (\Exception $e) {
           
            Logger::setLogLevel('error');
            Logger::error($e->getMessage()); 
            throw new \Exception('Database connection failed: ' . $e->getMessage());
        }
    }
}
