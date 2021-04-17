<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Taskshi;
use Auth;
use Carbon\Carbon;

class TaskshiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function store(Request $request)
    {
        $task = new Taskshi;
        $task->task_name   = $request->task_name;
        $task->owner_id    = Auth::user()->id;
        $task->done        = false;
        $task->removed     = false;
        $task->save();
        return back();

    }
    public function delete($id)
    {
        Taskshi::findOrFail($id)->delete();
        return back();
    }

    public function edit($id)
    {
        $task = Taskshi::where('id',$id)->first();
        $tasks = Taskshi::all();
        return view('edit',compact('tasks','task'));
    }

    public function update(Request $request,$id)
    {
        $task = Taskshi::where('id',$id)->first();
        $task->task_name = $request->task_name;
        $task->owner_id = Auth::user()->id;
        $task->save();
        return back();
    }

    public function search(Request $request)
    {
         $date = Carbon::parse($request->date)->toDateString();
         $search = Taskshi::whereDate('created_at',$date)->where('owner_id',Auth::user()->id)->get();
         return view('search',compact('search'));
    }
    
    public function done($id)
    {
        $done = Taskshi::where('id',$id)->first();

        if($done->done == 0)
        {
            $done->done=1;
            $done->save();

        }else{
            $done->done=0;
            $done->save();
        }

        return back();
        
    }

    //end
}
