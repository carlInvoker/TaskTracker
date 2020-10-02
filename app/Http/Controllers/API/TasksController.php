<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Validator;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;


class TasksController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */



     public function createTask(Request $request)
     {
       $validator = Validator::make($request->all(), [
         'title' => 'required|string|max:255',
         'description' => 'required|string',
         'status' => [
                      'required',
                       Rule::in(['View', 'In Progress', 'Done']),
                     ],
       ]);
       if ($validator->fails())
       {
          return response(['errors'=>$validator->errors()->all()], 422);
       }
       $task = new Task;
       $task->title = $request->title;
       $task->description = $request->description;
       $task->status = $request->status;
       $task->user_id = $request->user('api')->user_id;
       $task->save();
       $response = ['message' => 'task created'];
       return response($response, 200);
     }


     public function updateTask(Request $request)
     {
       $validator = Validator::make($request->all(), [
         'id' => 'integer|required',
         'title' => 'required|string|max:255',
         'description' => 'required|string',
         'status' => [
                      'required',
                       Rule::in(['View', 'In Progress', 'Done']),
                     ],
         'user_id' => 'integer',
       ]);
       if ($validator->fails())
       {
          return response(['errors'=>$validator->errors()->all()], 422);
       }
       $task = Task::find($request->id);
       if(!$task) {
         $response = ['message' => 'task not found'];
         return response($response, 200);
       }
       $task->title = $request->title;
       $task->description = $request->description;
       $task->status = $request->status;
       if(!$request->user_id) {
         $task->user_id = $request->user_id;
       }
       $task->save();
       $response = ['message' => 'task updated'];
       return response($response, 200);
     }


     public function changeTaskStatus(Request $request)
     {
       $validator = Validator::make($request->all(), [
         'id' => 'integer|required',
         'status' => [
                      'required',
                       Rule::in(['View', 'In Progress', 'Done']),
                     ],
       ]);
       if ($validator->fails())
       {
          return response(['errors'=>$validator->errors()->all()], 422);
       }
       $task = Task::find($request->id);
       if(!$task) {
         $response = ['message' => 'task not found'];
         return response($response, 200);
       }
       $task->status = $request->status;
       $task->save();
       $response = ['message' => 'task status changed'];
       return response($response, 200);
     }


     public function deleteTask(Request $request)
     {
       $validator = Validator::make($request->all(), [
         'id' => 'integer|required',
       ]);
       if ($validator->fails())
       {
          return response(['errors'=>$validator->errors()->all()], 422);
       }
       $task = Task::find($request->id);
       if(!$task) {
         $response = ['message' => 'task not found'];
         return response($response, 200);
       }
       $task->delete();
       $response = ['message' => 'task deleted'];
       return response($response, 200);
     }


     public function getTasks(Request $request)
     {
       $validator = Validator::make($request->all(), [
         'sortBy' => [
                       Rule::in(['status', 'users_desc', 'users_asc']),
                     ],
         'statusField' => [
                      Rule::in(['View', 'In Progress', 'Done']),
         ],
       ]);
       if ($validator->fails())
       {
          return response(['errors'=>$validator->errors()->all()], 422);
       }
       switch ($request->sortBy) {
        case 'users_asc':
            $tasks = Task::with('user')->get()->sortBy('user.created_at');
            break;
        case 'users_desc':
            $tasks = Task::with('user')->get()->sortByDesc('user.created_at');
            break;
        case 'status':
            if(!$request->statusField) {
              $response = ['errors' => 'Status for filter required !'];
              return response($response, 422);
            }
            $tasks = Task::where('status', $request->statusField)->get();
            break;
        default:
            $tasks = Task::get();
            break;
       }
       $response = ['tasks' => $tasks];
       return response($response, 200);
     }


     public function changeTaskUser(Request $request)
     {
       $validator = Validator::make($request->all(), [
         'id' => 'integer|required',
         'user_id' => 'integer|required',
       ]);
       if ($validator->fails())
       {
          return response(['errors'=>$validator->errors()->all()], 422);
       }
       $task =  Task::find($request->id);
       if(!$task) {
         $response = ['message' => 'task not found'];
         return response($response, 200);
       }
       $task->user_id = $request->user_id;
       $task->save();
       $response = ['message' => 'task user changed'];
       return response($response, 200);
     }

}
