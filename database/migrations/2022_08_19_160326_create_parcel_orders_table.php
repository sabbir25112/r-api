<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParcelOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parcel_orders', function (Blueprint $table) {
            $table->id();

            $table->integer('order_id');
            $table->string('customer_name')->nullable();
            $table->string('customer_mobile');
            $table->string('customer_address');
            $table->integer('city_id');
            $table->date('pickup_date')->nullable();
            $table->string('order_request')->nullable();
            $table->string('delivery_shift')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parcel_orders');
    }
}
