<?php
use Illuminate\Database\Capsule\Manager as Capsule;
use App\Core\Database;

require __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();
Database::init();

// Get the latest batch number
$batch = Capsule::table('migrations')->max('batch');

if (!$batch) {
    echo "No migrations to rollback.\n";
    exit;
}

$migrations = Capsule::table('migrations')->where('batch', $batch)->get();

foreach ($migrations as $migration) {
    $file = __DIR__ . "/../database/migrations/{$migration->migration}.php";
    
    if (file_exists($file)) {
    
        require_once $file;
        $className = pathinfo($file, PATHINFO_FILENAME);
        

        if (class_exists($className)) {
            $instance = new $className();
            $instance->down();

            // Remove migration record from database
            Capsule::table('migrations')->where('migration', $migration->migration)->delete();

            echo "Rolled back: {$migration->migration}\n";
        }
    }
}
