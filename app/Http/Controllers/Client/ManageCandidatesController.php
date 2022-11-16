<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManageCandidatesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user=Auth::user();
        $projects=$user->projects();
        // $proposedFreelnacers2=$proposedFreelnacers->proposedFreelnacers;
        // dd($proposedFreelnacers2);
        return view('client.candidates.index',['projects'=>$projects]);

    }

    /**
     * Show the Proposal Details.
     *
     * @return \Illuminate\Http\Response
     */
    public function details($user_id,$project_id)
    {
        $user=Auth::user();
        $projects=$user->projects()->findOrFail($project_id);
        $freelancer=$projects->proposedFreelnacers()->find($user_id);
        if(!$freelancer){
            return redirect()->route('client.projects.index')->with('message','Propoasl has been Deleted');
        }
        return view('client.candidates.details',['freelancer'=>$freelancer]);
    }

    public function accept($freelancer_id,$proposal_id,$project_id){
        $user=Auth::user();
       $project= $user->projects()->find($project_id);
      $proposal=$project->proposals()->where('id',$proposal_id)->where('freelancer_id',$freelancer_id)->update(['status'=>'accepted']);
       $freelancer=User::find($freelancer_id);
       return redirect()->route('client.candidate.details',[$freelancer_id,$project_id]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user=Auth::user();
        $projects=$user->projects()->findOrFail($id);
        $proposedFreelnacers=$projects->proposedFreelnacers()->paginate(3);
        $countFreelnacers=$projects->proposedFreelnacers()->count();
        // $proposedFreelnacers2=$proposedFreelnacers->proposedFreelnacers;
        // dd($proposedFreelnacers2);
        return view('client.candidates.index',['proposedFreelnacers'=>$proposedFreelnacers,'count'=>$countFreelnacers,'project'=>$projects]);
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
    public function destroy($user_id,$project_id)
    {
        $user=Auth::user();
        $project=$user->projects()->find($project_id);

        $project->proposals()->where('freelancer_id',$user_id)->update(['status'=>'declined']);
        $project->proposals()->where('freelancer_id',$user_id)->forceDelete();

        return redirect()->route('client.candidate',[$project->id])->with('message','Proposal Deleted');
    }
}
