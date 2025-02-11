<?php

use Illuminate\Database\Capsule\Manager as Capsule;

class announcements {
    public function up() {
        Capsule::schema()->create('announcements', function ($table) {
            $table->increments('id');
            $table->timestamps();
        });
    }

    public function down() {
        Capsule::schema()->dropIfExists('announcements');
    }
}