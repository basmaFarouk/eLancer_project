<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Freelancer;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        // dd(Project::count());\\
        $projects_count=Project::count();
        $freelancers_count=User::where('type','freelancer')->count();
        $clients_count=User::where('type','freelancer')->count();
         $recent_project=Project::with('category','tags')->latest()->where('status','open')->limit(5)->get();
        $categories = Category::all();

        return view('home',['recent_project'=>$recent_project,
        'categories'=>$categories,
        'freelancers_count'=>$freelancers_count,
        'clients_count'=>$clients_count,
        'projects_count'=>$projects_count,
    ]);
    }
}
