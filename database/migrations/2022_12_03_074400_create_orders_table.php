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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users','id')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('address_id')->constrained('user_addresses','id')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('coupon_id')->constrained('coupons','id')->onDelete('cascade')->onUpdate('cascade');
            $table->tinyInteger('status')->default(0);
            $table->unsignedInteger('total_amount');
            $table->unsignedInteger('delivery_amount')->nullable();
            $table->unsignedInteger('coupon_amount')->nullable();
            $table->unsignedInteger('paying_amount');
            $table->enum('payment_type',['pos','cash','shabaNumber','cardToCard','online']);
            $table->tinyInteger('payment_status')->default(0);
            $table->text('description')->nullable();
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
        Schema::dropIfExists('orders');
    }
};
