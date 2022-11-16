<?php

namespace App\Http\Controllers\Freelancer;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Project;
use App\Models\Proposal;
use App\Notifications\NewProposalNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class ProposalsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $user=Auth::guard('web')->user();
        // dd($user);
        // dd($user->proposals());
        $proposals=$user->proposals()->with('project')->latest()->paginate(3);
        // dd($proposals);
        return view('freelancer.proposals.index',['proposals'=>$proposals]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($project_id)
    {
        $project = Project::findOrFail($project_id);
        // if($project->status !=='open'){
        //     return redirect()->back()->with('message',"You can not apply to this Project") ;
        // }



        return view('freelancer.proposals.create',[
            'project'=>$project,
            'proposal'=>new Proposal(),
            'units'=>Proposal::units(),
         ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$project_id)
    {
        //عشان امنعه لو حاول برده يعمل >> submit
        $project = Project::findOrFail($project_id);
        if($project->status !=='open'){
            return redirect()->route('freelancer.proposals.index')->with('message',"You can not apply to this Project") ;
        }

         //Check if the user has applied to this project
         $user=Auth::guard('web')->user();
         if($user->id == $project->user_id){
            return redirect()->route('client.projects.index')->with('message','You are the Owner of this project');
         }
         if($user->proposedProjects()->find($project_id)){
             return redirect()->route('freelancer.proposals.index')->with('message','You already submitted proposal to this project');
         }

         if(!$user->freelancer->first_name){
            return redirect()->route('freelancer.profile.edit')->with('message','Please Complete Your Profile');
         }

        $request->validate([
            'description'=>['required','string'],
            'cost'=>['required','numeric','min:1'],
            'duration'=>['required','int','min:1'],
            'duration_unit'=>['required','in:day,week,month,year'],
        ]);

        $request->merge([
            'project_id'=>$project_id,
            // 'freelancer_id'=>$user->id
            'status'=>'pending',
        ]);

        // $proposal=Proposal::create($request->all());

       $proposal= $user->proposals()->create($request->all());

        //Notification
        $project->user->notify(new NewProposalNotification($proposal,$user));

        // $admins =Admin::all();
        // foreach($admins as $admin){
        //     $admin->notify(new NewProposalNotification($proposal,$user));
        // }
        // Notification::send($admins,new NewProposalNotification($proposal,$user));

        return redirect()->route('freelancer.proposals.index')->with('message','Your Proposal has been sumbitted');
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user=Auth::user();
        $user->proposals()->where('id',$id)->forceDelete();
        return redirect()->route('freelancer.proposals.index')->with('message','Propoasl has been Deleted');
    }
}
