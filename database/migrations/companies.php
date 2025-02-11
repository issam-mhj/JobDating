<?php

use Illuminate\Database\Capsule\Manager as Capsule;

class companies
{
    public function up()
    {
        Capsule::schema()->create('companies', function ($table) {
            $table->increments('id');
            $table->string('company_name', 100)->nullable(false);
            $table->text('details')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    public function down()
    {
        Capsule::schema()->dropIfExists('companies');
    }
}
