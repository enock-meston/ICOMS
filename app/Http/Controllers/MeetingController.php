<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MeetingController extends Controller
{
    public function index()
    {
        $title    = "Meetings";
        $Meetings = DB::select('CALL sp_meetings(?, ?, ?, ?, ?, ?, ?)', [
            'SELECT_ALL', null, null, null, null, null, null
        ]);
        $Users = User::orderBy('name', 'asc')->get();

        return view('meeting.index', compact('title', 'Meetings', 'Users'));
    }

    public function handleAction(Request $request)
    {
        // Validate input
        $request->validate([
            'action'       => 'required|in:INSERT,UPDATE,DELETE',
            'id'           => 'nullable|required_if:action,UPDATE,DELETE|integer',
            'meeting_type' => 'nullable|required_if:action,INSERT,UPDATE|string|max:100',
            'date'         => 'nullable|required_if:action,INSERT,UPDATE|date',
            'location'     => 'nullable|required_if:action,INSERT,UPDATE|string|max:255',
            'called_by'    => 'nullable|required_if:action,INSERT,UPDATE|integer',
            'minutes_file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        if (auth()->guard('web')->check()) {
            $currentUser = auth()->guard('web')->user();
        } elseif (auth()->guard('cooperative')->check()) {
            $currentUser = auth()->guard('cooperative')->user();
        }
        $currentUserId = $currentUser->id;

        // Handle file upload
        $minutesFile = null;
        if ($request->hasFile('minutes_file')) {
            $minutesFile = $request->file('minutes_file')
                                    ->store('meetings/minutes', 'public');
        } elseif ($request->action === 'UPDATE') {
            // Keep existing file if no new file uploaded
            $existing    = DB::select('CALL sp_meetings(?, ?, ?, ?, ?, ?, ?)', [
                'SELECT', $request->id, null, null, null, null, null
            ]);
            $minutesFile = $existing[0]->minutes_file ?? null;
        }

        DB::statement(
            'CALL sp_meetings(?, ?, ?, ?, ?, ?, ?)',
            [
                $request->action,   // p_action
                $request->id,       // p_id
                $request->meeting_type, // p_meeting_type
                $request->date,     // p_date
                $request->location, // p_location
                $request->called_by ?? $currentUserId, // p_called_by
                $minutesFile,       // p_minutes_file
            ]
        );

        return back()->with(
            'success',
            'Action ' . $request->action . ' performed successfully!'
        );
    }
}