<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Task;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        if(\Auth::check()){
            $user = \Auth::user();
            $tasks = $user->tasklists()->orderBy('created_at', 'desc')->paginate(10);
        
        return view('tasks.index', ['tasks' => $tasks,]);
        }
        
        else{
            return view('welcome');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $task = new Task;
        return view('tasks.create', ['task' => $task,]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        if(\Auth::check()){
        $this->validate($request, [
            'status' => 'required|max:10',
            'content' => 'required|max:191',
            ]);
        
        //$task = new Task;
        //$task->status = $request->status;
        //$task->content = $request->content;
        //$task->save();
        
        $request->user()->tasklists()->create([
            'status' => $request->status,
            'content' => $request->content,
            ]);
        
        return redirect('/');
        //return back();
        }
        else{
            return view('welcome');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(\Auth::check()){
        $task = Task::find($id);
        return view('tasks.show', ['task' => $task, ]);
        }
        else{
            return view('welcome');
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(\Auth::check()){
        $task = Task::find($id);
        return view('tasks.edit', ['task' => $task, ]);
        }
        
        else{
            return view('welcome');
        }
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
        if(\Auth::check()){
        $this->validate($request, [
            'status' => 'required|max:10',
            'content' => 'required|max:191',
            ]);
        
        $task = Task::find($id);
        $task->status = $request->status;
        $task->content = $request->content;
        $task->save();
        
        return redirect('/');
        }
        
        else{
            return view('welcome');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tasklist = \App\Task::find($id);
        if(\Auth::id() === $tasklist->user_id){
        
        
        $task = Task::find($id);
        $task->delete();
        }
        
        //$tasklist = \App\Task::find($id);
        
        //if(\Auth::id() === $tasklist->user_id){
         //   $tasklist->delete();
        //}
        
        return redirect('/');
    }
}
