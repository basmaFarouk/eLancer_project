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
        Schema::create('freelancers', function (Blueprint $table) {
            // $table->id();
            $table->foreignId('user_id')->primary()->constrained('users')->cascadeOnDelete();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('title')->nullable();
            $table->string('profile_photo_path')->nullable();
            $table->string('country');
            $table->enum('gender',['male','female']);
            $table->date('birthday')->nullable();
            $table->text('description')->nullable();
            $table->boolean('veriried')->default(0);
            $table->unsignedFloat('hourly_rate')->nullable();
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
        Schema::dropIfExists('freelancers');
    }
};
