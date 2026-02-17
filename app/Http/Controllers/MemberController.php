<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class MemberController extends Controller
{
    //
    public function index()
    {
        $title = "Member";
        $Members = Member::orderBy('created_at', 'DESC')->get();
        $Groups = Group::orderBy('created_at', 'DESC')->get();
        return view('member.index', compact('title', 'Members', 'Groups'));
    }

    public function handleAction(Request $request)
    {
        // Validate input
        $request->validate([
            'action'        => 'required|in:INSERT,UPDATE,DELETE',
            'id'            => 'nullable|required_if:action,UPDATE,DELETE|integer',
            // 'member_code'   => 'nullable|required_if:action,INSERT,UPDATE|string|max:50',
            'names'         => 'nullable|required_if:action,INSERT,UPDATE|string|max:255',
            'phone'         => 'nullable|required_if:action,INSERT,UPDATE|string|max:20',
            'gender'        => 'nullable|required_if:action,INSERT,UPDATE|string|in:MALE,FEMALE',
            'group_id'      => 'nullable|required_if:action,INSERT,UPDATE|integer',
            'national_ID'   => 'nullable|required_if:action,INSERT,UPDATE|string|max:50',
            'joinDate'      => 'nullable|required_if:action,INSERT,UPDATE|date',
            'Shares'        => 'nullable|required_if:action,INSERT,UPDATE|numeric',
            'status'        => 'nullable|required_if:action,INSERT,UPDATE|string|max:50',
        ]);


        DB::statement(
            'CALL sp_members(?,?,?,?,?,?,?,?,?,?,?)',
            [
                $request->action,    // p_action
                $request->id,        // p_id
                NULL,                // p_member_code (ignored, SP will generate automatically)
                $request->names,     // p_names
                $request->phone,     // p_phone
                $request->gender,    // p_gender
                $request->group_id,  // p_group_id
                $request->national_ID, // p_national_ID
                $request->joinDate,  // p_joinDate
                $request->Shares,    // p_shares
                $request->status     // p_status
            ]
        );


        return back()->with('success', 'Action ' . $request->action . ' performed successfully!');
    }
}
