<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHouseholdMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('household_members', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('household_head_id')->nullable();
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('ext_name')->nullable();
            $table->string('relasyon_sa_punong_pamilya')->nullable();
            $table->string('kasarian')->nullable();
            $table->date('kapanganakan')->nullable();
            $table->string('trabaho')->nullable();
            $table->string('pinagtratrabahuhang_lugar')->nullable();
            $table->string('sektor')->nullable();
            $table->string('kondisyon_ng_kalusugan')->nullable();
            $table->timestamps();
            $table->foreign('household_head_id')->references('id')->on('household_heads')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('household_members');
    }
}
