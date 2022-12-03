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
        Schema::create('attribute_category', function (Blueprint $table) {
            $table->foreignId('attribute_id')->constrained('attributes','id')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('category_id')->constrained('categories','id')->onDelete('cascade')->onUpdate('cascade');
            $table->primary(['attribute_id','category_id']);
            $table->boolean('is_filter')->default(0);
            $table->boolean('is_variation')->default(0);
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
        Schema::dropIfExists('attribute_category');
    }
};
