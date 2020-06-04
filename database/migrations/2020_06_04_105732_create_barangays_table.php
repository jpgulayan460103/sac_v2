<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barangays', function (Blueprint $table) {
            $table->id();
            $table->string('barangay_name')->nullable();
            $table->string('barangay_psgc')->nullable();
            $table->string('province_name')->nullable();
            $table->string('province_psgc')->nullable();
            $table->string('city_name')->nullable();
            $table->string('city_psgc')->nullable();
            $table->string('district')->nullable();
            $table->string('subdistrict')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('barangays');
    }
}
