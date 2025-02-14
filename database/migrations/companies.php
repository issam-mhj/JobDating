<?php

use Illuminate\Database\Capsule\Manager as Capsule;

class companies
{
    public function up()
    {
        Capsule::schema()->create('companies', function ($table) {
          
            $table->id('id');
            $table->string('company_name', 100)->nullable(false);
            $table->string('email', 100);
            $table->string('number', 100);
            $table->string('location', 100);
            $table->string('logo', 100)->nullable();
            $table->text('details')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Capsule::schema()->dropIfExists('companies');
    }
}
