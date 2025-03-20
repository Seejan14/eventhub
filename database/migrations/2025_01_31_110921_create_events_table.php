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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->foreignId('event_category_id')->constrained('event_categories')->onDelete('cascade');
            $table->text('description');
            $table->string('image_url');
            $table->string('image_public_id');
            $table->double('price');
            $table->string('country');
            $table->integer('status')->default(1)->comment('0=> inactive 1=>active');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->integer('total_space')->nullable()->default(0);
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
        Schema::dropIfExists('packages');
    }
};
