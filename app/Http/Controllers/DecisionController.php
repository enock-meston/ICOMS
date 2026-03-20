<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DecisionController extends Controller
{
    public function index()
    {
        $title     = "Decisions";
        $Decisions = DB::select('CALL sp_decisions(?, ?, ?, ?, ?, ?, ?, ?)', [
            'SELECT_ALL', null, null, null, null, null, null, null
        ]);
        $Meetings = DB::select('CALL sp_meetings(?, ?, ?, ?, ?, ?, ?)', [
            'SELECT_ALL', null, null, null, null, null, null
        ]);
        $Users = User::orderBy('name', 'asc')->get();

        return view('decision.index', compact('title', 'Decisions', 'Meetings', 'Users'));
    }

    public function handleAction(Request $request)
    {
        // Validate input
        $request->validate([
            'action'              => 'required|in:INSERT,UPDATE,DELETE',
            'id'                  => 'nullable|required_if:action,UPDATE,DELETE|integer',
            'meeting_id'          => 'nullable|required_if:action,INSERT,UPDATE|integer',
            'title'               => 'nullable|required_if:action,INSERT,UPDATE|string|max:255',
            'description'         => 'nullable|required_if:action,INSERT,UPDATE|string',
            'responsible_user_id' => 'nullable|required_if:action,INSERT,UPDATE|integer',
            'due_date'            => 'nullable|required_if:action,INSERT,UPDATE|date',
            'status'              => 'nullable|required_if:action,INSERT,UPDATE|in:OPEN,IN_PROGRESS,COMPLETED,CANCELLED',
        ]);

        if (auth()->guard('web')->check()) {
            $currentUser = auth()->guard('web')->user();
        } elseif (auth()->guard('cooperative')->check()) {
            $currentUser = auth()->guard('cooperative')->user();
        }
        $currentUserId = $currentUser->id;

        DB::statement(
            'CALL sp_decisions(?, ?, ?, ?, ?, ?, ?, ?)',
            [
                $request->action,               // p_action
                $request->id,                   // p_id
                $request->meeting_id,           // p_meeting_id
                $request->title,                // p_title
                $request->description,          // p_description
                $request->responsible_user_id,  // p_responsible_user_id
                $request->due_date,             // p_due_date
                $request->status,               // p_status
            ]
        );

        return back()->with(
            'success',
            'Action ' . $request->action . ' performed successfully!'
        );
    }
}