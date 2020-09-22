<?php

namespace App\Http\Controllers\Api;

use App\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

class TasksController extends Controller 
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::latest()->get();

        return response($tasks, Response::HTTP_ACCEPTED);
    }  

    public function completeTask(Task $task)
    {
        $task = $task->complete(true);

        return response($task, Response::HTTP_ACCEPTED);
    }

    public function activateTask(Task $task)
    {
        $task = $task->complete(false);

        return response($task, Response::HTTP_ACCEPTED);
    }

    public function getTask(Task $task)
    {
        return response($task, Response::HTTP_ACCEPTED);
    }

    public function saveTask(Request $request)
    {
        $task = Task::whereId($request->id)->first();

        if($task) {
            $task->update([
                'title' => $request->title,
                'description' => $request->description,
            ]);
        } else {
            $task = Task::create([
                'title' => $request->title,
                'description' => $request->description,
                'owner_id' => auth()->id()
            ]);
        }
    
        return response($task, Response::HTTP_ACCEPTED);
    }

    public function deleteTask(Task $task)
    {
        $task->delete($task);

        return response(true, Response::HTTP_ACCEPTED);
    }

    public function clearCompletedTasks()
    {
        Task::where('completed', 1)->delete();

        return response(true, Response::HTTP_ACCEPTED);
    }

    public function deleteAllTasks()
    {
        Task::truncate();

        return response(true, Response::HTTP_ACCEPTED);
    }
}