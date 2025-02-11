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
                'driver' => $_ENV['DB_DRIVER'],
                'host' => $_ENV['DB_HOST'],
                'database' => $_ENV['DB_NAME'],
                'username' => $_ENV['DB_USER'],
                'password' => $_ENV['DB_PASSWORD'],
            ]);

            $capsule->setAsGlobal();
            $capsule->bootEloquent();

            // Create migrations table if not exists
            if (!Capsule::schema()->hasTable('migrations')) {
                Capsule::schema()->create('migrations', function ($table) {
                    $table->increments('id');
                    $table->string('migration');
                    $table->integer('batch');
                    $table->timestamps();
                });
            }
        } catch (\Exception $e) {

            Logger::setLogLevel('error');
            Logger::error($e->getMessage());
            throw new \Exception('Database connection failed: ' . $e->getMessage());
        }
    }
}
