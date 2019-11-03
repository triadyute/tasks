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

    public function destroy(Request $request, Task $task){
        $task->delete();
        return response()->json($task);

    }
}