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
            $table->unsignedInteger('household_head_id')->nullale();
            $table->string('first_name')->nullale();
            $table->string('middle_name')->nullale();
            $table->string('last_name')->nullale();
            $table->string('ext_name')->nullale();
            $table->string('relasyon_sa_punong_pamilya')->nullale();
            $table->string('kasarian')->nullale();
            $table->date('kapanganakan')->nullale();
            $table->string('trabaho')->nullale();
            $table->string('pinagtratrabahuhang_lugar')->nullale();
            $table->string('sektor')->nullale();
            $table->string('kondisyon_ng_kalusugan')->nullale();
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
