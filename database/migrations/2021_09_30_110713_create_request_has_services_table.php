<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestHasServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_has_services', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_request_id');
            $table->unsignedBigInteger('service_types_id');
            $table->timestamps();

            $table->foreign('user_request_id')->references('id')->on('user_requests')
                ->onDelete('cascade');
            $table->foreign('service_types_id')->references('id')->on('service_types')
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
        Schema::dropIfExists('request_has_services');
    }
}
