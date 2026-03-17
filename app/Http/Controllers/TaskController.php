<?php

namespace App\Http\Controllers;

use App\Models\CoOperative\CoUser;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    //
    public function index()
    {
        $title = "Tasks";
        $Tasks = Task::orderBy('id', 'asc')->get();
        $users = CoUser::orderBy('id', 'asc')->get();
        return view('task.index', compact('title', 'Tasks', 'users'));
    }

    // handle action
    public function handleAction(Request $request)
    {
        $request->validate([
            'action'               => 'required|in:INSERT,UPDATE,DELETE',
            'id'                   => 'nullable|required_if:action,UPDATE,DELETE|integer',
            'title'                => 'nullable|required_if:action,INSERT,UPDATE|string|max:255',
            'description'          => 'nullable|string',
            'assigned_to'          => 'nullable|required_if:action,INSERT,UPDATE|integer',
            // 'created_by'           => 'nullable|integer',
            'related_decision_id'  => 'nullable|integer',
            'related_plan_id'      => 'nullable|integer',
            'priority'             => 'nullable|required_if:action,INSERT,UPDATE|string|max:50',
            'start_date'           => 'nullable|date',
            'due_date'             => 'nullable|date',
            'status'               => 'nullable|required_if:action,INSERT,UPDATE|string|max:50',
        ]);
// Detect authenticated user (web or cooperative)
        if (auth()->guard('web')->check()) {
            $currentUser = auth()->guard('web')->user();
        } elseif (auth()->guard('cooperative')->check()) {
            $currentUser = auth()->guard('cooperative')->user();
        }

        $currentUserId = $currentUser->id;
        DB::statement(
            'CALL sp_tasks_action(?,?,?,?,?,?,?,?,?,?,?,?)',
            [
                $request->action,                // p_action
                $request->id,                    // p_id
                $request->title,                 // p_title
                $request->description,           // p_description
                $request->assigned_to,           // p_assigned_to
                $currentUserId,                  // p_created_by
                $request->related_decision_id,   // p_related_decision_id
                $request->related_plan_id,       // p_related_plan_id
                $request->priority,              // p_priority
                $request->start_date,            // p_start_date
                $request->due_date,              // p_due_date
                $request->status                 // p_status
            ]
        );

        return back()->with(
            'success',
            'Action ' . $request->action . ' performed successfully!'
        );
    }
}
