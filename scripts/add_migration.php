<?php

$filename = $argv[1] ?? null;

if (!$filename) {
    echo "Usage: php scripts/create_migration.php CreateUsersTable\n";
    exit;
}

// Generate timestamped migration file name
// $timestamp = date('Yms');
$migrationClass = $filename;

$migrationFile = __DIR__ . "/../database/migrations/$migrationClass.php";


// Extract table name from migration name (assumes "Create{TableName}Table" convention)
preg_match('/Create(.*?)Table/', $migrationClass, $matches);
$tableName = $filename;


// Generate migration template with a dynamic table name
$template = <<<PHP
<?php

use Illuminate\Database\Capsule\Manager as Capsule;

class $migrationClass {
    public function up() {
        Capsule::schema()->create('$tableName', function (\$table) {
            \$table->increments('id');
            \$table->timestamps();
        });
    }

    public function down() {
        Capsule::schema()->dropIfExists('$tableName');
    }
}
PHP;

// Create migration file
file_put_contents($migrationFile, $template);
echo "Migration created: $migrationFile\n";
