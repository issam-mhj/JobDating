<?php
use Illuminate\Database\Capsule\Manager as Capsule;
use App\Core\Database;

require __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();
Database::init();

// Get the max batch number and increment it
$batch = Capsule::table('migrations')->max('batch') + 1;
$migrationsDir = __DIR__ . '/../database/migrations/';
$files = glob($migrationsDir . '*.php');

foreach ($files as $file) {
    
    $migrationName = pathinfo($file, PATHINFO_FILENAME);
    $className = $migrationName;
    
    

    // Check if migration is already applied
    if (Capsule::table('migrations')->where('migration', $migrationName)->exists()) {
        echo "Skipping: $migrationName\n";
        continue;
    }

    // Require and instantiate the class dynamically
    require_once $file;
    
    // $className = str_replace('_', '', ucwords($migrationName, '_'));


    if (class_exists($className)) {
       
        $migration = new $className();
        $migration->up();

        // Store the migration in the database
        Capsule::table('migrations')->insert([
            'migration' => $migrationName,
            'batch' => $batch,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        echo "Migrated: $migrationName\n";
    }
}
