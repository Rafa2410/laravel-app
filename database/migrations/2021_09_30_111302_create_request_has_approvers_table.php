<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestHasApproversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_has_approvers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_request_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('user_request_id')->references('id')->on('user_requests')
                ->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('request_has_approvers');
    }
}
