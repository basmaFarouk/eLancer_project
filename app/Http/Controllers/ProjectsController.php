<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Proposal;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    //
    public function index(){
        $projects=Project::latest()->paginate();
        return view('projects.index',[
            'projects'=>$projects
        ]);
    }

    public function show(Project $project){
        // dd($project->id);
        $tags=[];
        // foreach($project->tags as $tag){
        //     $tags[]=$tag->pivot->tag_id;
        // }
        $similar_projects=Project::where('category_id',$project->category_id)->take(2)->get();


        // dd($tags);

        return view('projects.show',['project'=>$project,'units'=>Proposal::units(),'similar_projects'=>$similar_projects]);
    }
}
