<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHouseholdHeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('household_heads', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('ext_name')->nullable();
            $table->string('kasarian')->nullable();
            $table->string('tirahan')->nullable();
            $table->string('kalye')->nullable();
            $table->string('uri_ng_id')->nullable();
            $table->string('numero_ng_id')->nullable();
            $table->date('kapanganakan')->nullable();
            $table->string('trabaho')->nullable();
            $table->integer('buwanang_kita')->nullable();
            $table->string('cellphone_number')->nullable();
            $table->string('pinagtratrabahuhang_lugar')->nullable();
            $table->string('sektor')->nullable();
            $table->string('kondisyon_ng_kalusugan')->nullable();
            $table->string('bene_uct')->nullable();
            $table->string('bene_4ps')->nullable();
            $table->string('katutubo')->nullable();
            $table->string('katutubo_name')->nullable();
            $table->string('bene_others')->nullable();
            $table->string('others_name')->nullable();
            $table->date('petsa_ng_pagrehistro')->nullable();
            $table->string('pangalan_ng_punong_barangay')->nullable();
            $table->string('pangalan_ng_lswdo')->nullable();
            $table->text('remarks')->nullable();
            $table->integer('sac_number');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();
            $table->unique('sac_number');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('household_heads');
    }
}
