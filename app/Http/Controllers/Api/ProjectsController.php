<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\ProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class ProjectsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum'])->except('index');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $entries = Project::latest()
        ->with([
            'user:id,name,email', //بحدد انهو كولمز ترجع من الريليشن
            'tags',
            'category',
            ])
        ->paginate(2);
        // return response()->json(['data'=>$entries,'message'=>'success'],200);
        return ProjectResource::collection($entries) ;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectRequest $request)
    {

        //File Uploads
        $data=$request->except('attachments');
      //  $data['attachments']=$this->uploadAttachments($request);


        $user = $request->user();
        // $request->merge([
        //     'user_id'=>$user->id  //Auth::id()
        // ]);

        // $project = Project::create($request->all());
       //بدل ما اجيب اليوزر اي دي فانا استخدمت الريليشن
        $project = $user->projects()->create($data);
        $tags=$request->input('tags');
        $tags=explode(',',$tags);
        $project->syncTags($tags);

        return response($project,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return new ProjectResource($project);
        //return $project->load(['category','user','tags']);
        // return Project::with('category')->find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $request->validate([

            'title'=>['sometimes','required','string','max:255'],
            'description'=>['sometimes','required','string'],
            'type'=>['sometimes','required','in:hourly,fixed'],
            'budget'=>['nullable','numeric','min:0']
        ]);

        $user=$request->user();
        $project=$user->projects()->findOrFail($id); //عشان محدش يقدر يجيب بروجكتس مش بتاعته
        $data=$request->except('attachments');

        //$data['attachments']=array_merge(($project->attachments ?? []),$this->uploadAttachments($request) ?? []);
        $project->update($data);

        //Update Tags
        $tags=$request->input('tags');
        $tags=explode(',',$tags);
        $project->syncTags($tags);
        return response($project,201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $user=Auth::guard('sanctum')->user();

        //Check user Permission
        if(!$user->tokenCan('projects.delete')){
            return Response::json([
                'message'=>'Permission Denied'
            ],403);
        }
        $project->delete();

        if($project->attachments){

            foreach($project->attachments as $file){
                Storage::disk('public')->delete($file);
            }
        }
    }
}
