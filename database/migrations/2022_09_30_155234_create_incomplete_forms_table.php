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
        Schema::create('incomplete_forms', function (Blueprint $table) {
            $table->id();
            $table->integer("helpdesk_user");
            $table->integer("village_id");
            $table->string("hh_id", 30);
            $table->string("member_id", 30);
            $table->integer("scheme_id");
            $table->string("status", 20)->default("incomplete");
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
        Schema::dropIfExists('incomplete_forms');
    }
};
