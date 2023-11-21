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
        Schema::create('confirm_applications', function (Blueprint $table) {
            $table->id();
            $table->integer("helpdesk_user");
            $table->integer("village_id");
            $table->string("hh_id", 30);
            $table->string("member_id", 30);
            $table->integer("scheme_id");
            $table->string("eligible_status", 20)->nullable();
            $table->smallInteger("documentation_status")->default(0);
            $table->string("documentation_date", 20)->nullable();
            $table->smallInteger("liasoning_status")->default(0);
            $table->string("liasoning_date", 20)->nullable();
            $table->smallInteger("govt_submission_status")->default(0);
            $table->string("govt_submission_date", 20)->nullable();
            $table->smallInteger("benefit_status")->default(0);
            $table->string("beneficiary_image", 255)->nullable();
            $table->string("benefit_date", 20)->nullable();
            $table->string("if_discrepancy", 300)->nullable();
            $table->string("reject_reason", 300)->nullable();
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
        Schema::dropIfExists('confirm_applications');
    }
};
