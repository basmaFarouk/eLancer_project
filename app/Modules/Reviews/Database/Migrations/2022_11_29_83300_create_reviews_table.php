<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration{

    public function up(){
        Schema::create('reviews',function(Blueprint $table){
            $table->id();
            $table->morphs('reviewable');
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('rating',[1,2,3,4,5])->default(1);
            $table->text('comment')->nullable();
            $table->enum('status',['published','pending','rejected'])->default('published');
            $table->timestamps();
        });
    }

    public function down(){
        Schema::dropIfExists('reviews');
    }
}
