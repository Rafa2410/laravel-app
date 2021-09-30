<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_requests', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('invoice_code');
            $table->bigInteger('request_num');
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('plant_id');
            $table->unsignedBigInteger('cost_center_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('status_id');
            $table->unsignedBigInteger('contact_id');
            $table->string('reason');
            $table->datetime('start_date');
            $table->datetime('end_date');
            $table->unsignedBigInteger('room_id');
            $table->boolean('can_interrump');
            $table->string('content');
            $table->bigInteger('number_persons');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade');
            $table->foreign('company_id')->references('id')->on('companies')
                ->onDelete('cascade');
            $table->foreign('plant_id')->references('id')->on('plants')
                ->onDelete('cascade');
            $table->foreign('cost_center_id')->references('id')->on('cost_centers')
                ->onDelete('cascade');
            $table->foreign('status_id')->references('id')->on('statuses')
                ->onDelete('cascade');
            $table->foreign('contact_id')->references('id')->on('users')
                ->onDelete('cascade');
            $table->foreign('room_id')->references('id')->on('rooms')
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
        Schema::dropIfExists('user_requests');
    }
}
