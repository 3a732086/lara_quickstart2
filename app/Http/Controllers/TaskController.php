<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    //

    public function __consrtuct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {

        $tasks = Task::where('user_id',$request->user()->id)->get();

        return view('tasks.index',[
            'tasks' => $tasks,
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|max:255',
        ]);

        $request->user()->tasks()->create([
            'name' => $request->name,
        ]);

        return redirect('/tasks');
    }

    public function destroy(Request $request, Task $task)
    {
        $this->authorize('destroy', $task); //可註解或略過
        $task->delete();
        return redirect('/tasks');
    }
}
