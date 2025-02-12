<?php

use Illuminate\Database\Capsule\Manager as Capsule;

class announcements {
    public function up() {
        Capsule::schema()->create('announcements', function ($table) {
            $table->id(); 
            $table->string('title'); 
            $table->text('description'); 
            $table->string('location'); 
            $table->string('job_requirments');
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down() {
        Capsule::schema()->dropIfExists('announcements');
    }
}