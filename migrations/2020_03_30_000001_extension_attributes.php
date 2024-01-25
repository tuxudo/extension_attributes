<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Capsule\Manager as Capsule;

class Extensionattributes extends Migration
{
    public function up()
    {
        $capsule = new Capsule();
        $capsule::schema()->create('extension_attributes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('serial_number');
            $table->string('displayname')->nullable();
            $table->text('result')->nullable();
            $table->string('displayincategory')->nullable();
            $table->string('datatype')->nullable();

            $table->index('serial_number');
            $table->index('displayname');
            $table->index('displayincategory');
            $table->index('datatype');
        });
    }
    
    public function down()
    {
        $capsule = new Capsule();
        $capsule::schema()->dropIfExists('extension_attributes');
    }
}
