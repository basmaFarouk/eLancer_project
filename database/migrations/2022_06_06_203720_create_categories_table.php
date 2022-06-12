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
        Schema::create('categories', function (Blueprint $table) {
            // $table->bigInteger('id')->unsigned()->autoIncrement()->primary();
            // $table->unsignedBigInteger('id')->autoIncrement()->primary();
            // $table->bigIncrements('id')->primary(); are equal to
            $table->id();

            //varchar 255
            $table->string('name',50)->unique();
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('img_path')->nullable();
            // $table->foreignId('parent_id')->nullable()->constrained('categories','id')->nullOnDelete();
            $table->unsignedBigInteger('parent_id')->nullable(); //for subcategories
            $table->foreign('parent_id')->references('id')->on('categories')->nullOnDelete(); //restricted is the default

            //created_at null
            //updated_at null
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
        Schema::dropIfExists('categories');
    }
};
