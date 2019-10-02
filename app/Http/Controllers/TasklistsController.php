<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TasklistsController extends Controller
{
    public function index()
    {
        $data = [];
        if (\Auth::check()) {
            $user = \Auth::user();
            $tasklists = $user->tasklists()->orderBy('created_at', 'desc')->paginate(10);
            
            $data = [
                'user' => $user,
                'tasklists' => $tasklists,
            ];
        }
        
        return view('welcome', $data);
    }
    
        public function store(Request $request)
    {
        $this->validate($request, [
            'content' => 'required|max:191',
        ]);

        $request->user()->tasklists()->create([
            'content' => $request->content,
        ]);

        return back();
    }
    
        public function destroy($id)
    {
        $micropost = \App\Task::find($id);

        if (\Auth::id() === $tasklists->user_id) {
            $tasklists->delete();
        }

        return back();
    }
    
}
