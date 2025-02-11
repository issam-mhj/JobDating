<?php
use Illuminate\Database\Capsule\Manager as Capsule;

class users {
    public function up() {
        // Ensure the ENUM type exists (PostgreSQL)
        Capsule::schema()->getConnection()->statement("DO $$ BEGIN 
            CREATE TYPE role AS ENUM ('user', 'admin'); 
        EXCEPTION 
            WHEN duplicate_object THEN NULL; 
        END $$;");

        Capsule::schema()->create('users', function ($table) {
            $table->increments('id');
            $table->string('username', 255)->unique();
            $table->string('email', 255)->unique();
            $table->string('password', 255);
            $table->enum('role', ['user', 'admin'])->default('user');
            $table->timestamp('created_at')->default(Capsule::raw('CURRENT_TIMESTAMP'))->nullable(false);
            $table->timestamp('updated_at')->default(Capsule::raw('CURRENT_TIMESTAMP'))->nullable(false);
        });
    }

    public function down() {
        Capsule::schema()->dropIfExists('users');
        Capsule::schema()->getConnection()->statement("DROP TYPE IF EXISTS role");
    }
}
