<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('beneficiaries', function (Blueprint $table) {
            $table->id();
            $table->integer("village_id");
            $table->string("hh_id", 20);
            $table->string("member_id", 25);
            $table->smallInteger("member_count");
            $table->string("name", 255);
            $table->string("full_address", 300);
            $table->string("landmark", 300);
            $table->string("age", 10);
            $table->string("marital_status", 30)->nullable();
            $table->string("gender", 10)->nullable();
            $table->string("income", 30)->nullable();
            $table->smallInteger("caste_certificate")->nullable();
            $table->string("type_of_house", 20)->nullable();
            $table->string("disability", 30)->nullable();
            $table->smallInteger("aadhaar_card")->nullable();
            $table->smallInteger("bank_account")->nullable();
            $table->smallInteger("election_card")->nullable();
            $table->string("widow_status", 30)->nullable();
            $table->smallInteger("status_of_women")->nullable();
            $table->smallInteger("religion")->nullable();
            $table->smallInteger("land_ownership")->nullable();
            $table->smallInteger("education_sts")->nullable();
            $table->string("height_cm", 10)->nullable();
            $table->string("weight_kg", 10)->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('beneficiaries');
    }
};
