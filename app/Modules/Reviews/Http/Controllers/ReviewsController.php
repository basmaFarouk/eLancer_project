<?php

namespace App\Modules\Reviews\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Reviews\Models\Review;

class ReviewsController extends Controller {

    public function index(){
        $reviews=Review::paginate();
        return view('reviews::reviews.index',compact('reviews'));
    }
}
