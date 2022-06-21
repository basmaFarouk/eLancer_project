<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\ProjectRequest;
use App\Models\Category;
use App\Models\Project;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // $category=[];
        $user = Auth::user();
        // $projects=Project::all();
        // foreach($projects as $project){
        //     if($project->user_id==$user->id){
        //         $category[$project->id]=Category::where('id',$project->category_id)->pluck('name');
        //     }
        // }
        // dd($category);

        // $projects = DB::table('users')
        // ->join('projects', 'projects.user_id', '=', 'users.id')
        // ->join('categories', 'projects.category_id', '=', 'categories.id')
        // ->select('users.email', 'categories.name as category_name', 'projects.*')->where('projects.user_id',Auth::id())
        // ->get();

        // dd($projects);




        $projects = Project::with('category')->where('user_id',$user->id)->paginate();
        $projects = $user->projects()->with('category.parent','tags')->paginate();


        return view('client.projects.index',['projects'=>$projects]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        return view('client.projects.create',['project'=>new Project()
        ,'types'=>Project::types(),'categories'=>$this->categories(),'tags'=>[]]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\ProjectRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectRequest $request)
    {
        //

        // dd($request->all());



        //File Uploads
        $data=$request->except('attachments');
        $data['attachments']=$this->uploadAttachments($request);
        // if($request->hasFile('attachments')){
        //     $files = $request->file('attachments');
        //     $attachments=[];
        //     foreach($files as $file){
        //     if($file->isValid()){ //
        //         $path=$file->store('/attachments',[
        //             'disk'=>'uploads',
        //         ]);
        //         $attachments[]=$path;
        //     }
        // }
        // // $request->merge([
        // //     'attachments'=>$attachments
        // //     // 'attachments'=>$path
        // // ]);
        // $data['attachments']=$attachments;
        // }
        // return $request->all();

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
        return redirect()->route('client.projects.index')->with(['Success '=>'Project Added']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $user=Auth::user();
        $project=$user->projects()->findOrFail($id); //عشان محدش يقدر يجيب بروجكتس مش بتاعته
        // $project=Project::findOrFail($id);

        return view('client.projects.show',compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $user=Auth::user();
        $project=$user->projects()->findOrFail($id); //عشان محدش يقدر يجيب بروجكتس مش بتاعته
        // $project=Project::where('user_id',$user->id)->findOrFail($id);
            // dd($project->attachments);
        return view('client.projects.edit',['project'=>$project
        ,'types'=>Project::types(),'categories'=>$this->categories(),
        'tags'=>$project->tags()->pluck('name')->toArray()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProjectRequest $request, $id)
    {
        //
        $user=Auth::user();
        $project=$user->projects()->findOrFail($id); //عشان محدش يقدر يجيب بروجكتس مش بتاعته
        $data=$request->except('attachments');

        $data['attachments']=array_merge(($project->attachments ?? []),$this->uploadAttachments($request) ?? []);
        $project->update($data);

        //Update Tags
        $tags=$request->input('tags');
        $tags=explode(',',$tags);
        $project->syncTags($tags);
        return redirect()->route('client.projects.index')->with(['Success '=>'Project Updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $user->projects()  is equal to  Project::where('user_id',Auth::id())
        // Project::where('user_id',Auth::id())->where('id',$id)->delete();
        $user=Auth::user();
        $project=$user->projects()->findOrFail($id);
        // $project->delete();
        foreach($project->attachments as $file){

                // dd($file);
            //unlink(storage_path('app/public'.$file));
            Storage::disk('public')->delete($file);
        }
        return redirect()->route('client.projects.index')->with(['Success '=>'Project Deleted']);
    }

    // public function deleteAttchment($id,$name){
    //     // dd("hellpo");
    //     $projects= Project::where('user_id',Auth::id())->findOrFail($id);

    //     foreach($projects->attachments as $index=>$value){
    //         // dd($projects->attachments);
    //         $a=$projects->attachments;
    //         if(basename($value)==$name){
    //             // dd($index);
    //             unset($a[$index]);
    //         }
    //          DB::table('projects')
    //           ->where('user_id', Auth::id())
    //           ->where('id',$id)
    //           ->update(['attachments' => $a]);
    //         // dd($projects->attachments);
    //     }
    //     return redirect()->route('client.projects.index')->with(['Success '=>'Project Deleted']);
    // }

    protected function categories(){
        return Category::pluck('name','id')->toArray();
    }

    protected function uploadAttachments(Request $request){

                //File Uploads

                if(!$request->hasFile('attachments')){
                    return ;
                }
                    $files = $request->file('attachments');
                    $attachments=[];
                    foreach($files as $file){
                    if($file->isValid()){ //
                        $path=$file->store('/attachments',[
                            'disk'=>'uploads',
                        ]);
                        $attachments[]=$path;
                    }
                }
                // $request->merge([
                //     'attachments'=>$attachments
                //     // 'attachments'=>$path
                // ]);

                // dd($attachments);
                return $attachments;
                }
    }

