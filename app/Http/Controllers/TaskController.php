<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Task;

class TaskController extends Controller
{
    public function home(){
        $tasks = Task::all();
        return view('tasks.tasks', compact('tasks'));
    }

    public function index(){
        $tasks = Task::with('project')->get();
        return response()->json($tasks);

    }

    public function store(Request $request){
        //dd(request()->all());
        $task = Task::create();
        $task->project_id = 1;
        $task->name = $request->name;
        $task->priority = $request->priority;
        //return $task;
        $task->save();
        return response()->json($task);
    }

    public function update(Request $request, Task $task){
        //dd(request()->all());
        $task->project_id = empty($request->project_id) ? $task->project_id: $request->project_id;
        $task->name = empty($request->name) ? $task->name: $request->name;
        $task->completed = empty($request->completed) ? $task->completed: $request->completed;
        $task->priority = empty($request->priority) ? $task->priority: $request->priority;
        $task->save();
        return response()->json($task);
    }

    public function destroy(Request $request, Task $task){
        $task->delete();
        return response()->json($task);

    }
}
