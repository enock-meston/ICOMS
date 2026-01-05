<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class MemberController extends Controller
{
    //
    public function index(){
        $title = "Member";
        $Member = Member::orderBy('created_at','DESC')->get();
        return view('member.index',compact('title','Member'));
    }

    public function handleMemberAction(Request $request)
{
    // Validate input
    $request->validate([
        'action'        => 'required|in:INSERT,UPDATE,DELETE',
        'id'            => 'nullable|required_if:action,UPDATE,DELETE|integer',
        'member_code'   => 'nullable|required_if:action,INSERT,UPDATE|string|max:50',
        'names'         => 'nullable|required_if:action,INSERT,UPDATE|string|max:255',
        'phone'         => 'nullable|required_if:action,INSERT,UPDATE|string|max:20',
        'gender'        => 'nullable|required_if:action,INSERT,UPDATE|string|in:MALE,FEMALE',
        'group_id'      => 'nullable|required_if:action,INSERT,UPDATE|integer',
        'national_ID'   => 'nullable|required_if:action,INSERT,UPDATE|string|max:50',
        'joinDate'      => 'nullable|required_if:action,INSERT,UPDATE|date',
        'Shares'        => 'nullable|required_if:action,INSERT,UPDATE|numeric',
        'status'        => 'nullable|required_if:action,INSERT,UPDATE|string|max:50',
    ]);

    // Optional: detect authenticated user (if needed for audit)
    if (auth()->guard('web')->check()) {
        $currentUser = auth()->guard('web')->user();
    } elseif (auth()->guard('cooperative')->check()) {
        $currentUser = auth()->guard('cooperative')->user();
    } else {
        $currentUser = null;
    }

    try {
        DB::statement(
            'CALL sp_members_crud(?,?,?,?,?,?,?,?,?,?,?)',
            [
                $request->action,          // p_action
                $request->id,              // p_id
                $request->member_code,     // p_member_code
                $request->names,           // p_names
                $request->phone,           // p_phone
                $request->gender,          // p_gender
                $request->group_id,        // p_group_id
                $request->national_ID,     // p_national_ID
                $request->joinDate,        // p_joinDate
                $request->Shares,          // p_shares
                $request->status           // p_status
            ]
        );

        return back()->with('success', 'Action ' . $request->action . ' performed successfully!');
    } catch (\Exception $e) {
        return back()->with('error', 'Error performing action: ' . $e->getMessage());
    }
}

}
