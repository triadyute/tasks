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
        return response()->json([$request->all()]);
    }
}