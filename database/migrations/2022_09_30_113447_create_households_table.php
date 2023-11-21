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
        Schema::create('households', function (Blueprint $table) {
            $table->id();
            $table->integer("village_id");
            $table->string("hh_id", 50);
            $table->string("name", 255);
            $table->string("qr_code", 50);
            $table->string("social_status", 20);
            $table->smallInteger("card_disbursement_status")->default(0);
            $table->string("social_eco_status", 20);
            $table->string("card_score", 20);
            $table->string("hh_income", 30);
            $table->string("caste", 20);
            $table->string("state", 50);
            $table->string("age", 10);
            $table->string("mobile", 11)->nullable();
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
        Schema::dropIfExists('households');
    }
};
