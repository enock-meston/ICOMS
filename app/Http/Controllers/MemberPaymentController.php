<?php

namespace App\Http\Controllers;

use App\Models\CoOperative\CoUser;
use App\Models\Member;
use App\Models\Member_Payment;
use App\Models\Rice_Delivery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MemberPaymentController extends Controller
{
    //
    public function index()
    {
        $title = "Member Payments";
        $payments = Member_Payment::orderBy('id', 'asc')->get();
        $members = Member::orderBy('id', 'asc')->get();
        $deliveries = Rice_Delivery::orderBy('id', 'asc')->get();
        return view('member-payment.index', compact('title', 'members', 'payments','deliveries'));
    }
    public function handleAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:INSERT,UPDATE,DELETE',
            'id' => 'nullable|required_if:action,UPDATE,DELETE|integer',
            'member_id' => 'nullable|required_if:action,INSERT,UPDATE|integer',
            'delivery_id' => 'nullable|required_if:action,INSERT,UPDATE|integer',
            'amount' => 'nullable|required_if:action,INSERT,UPDATE|numeric',
            'payment_Date' => 'nullable|required_if:action,INSERT,UPDATE|date',
            'payment' => 'nullable|string|max:50',
            'status' => 'nullable|required_if:action,INSERT,UPDATE|string|max:50',
        ]);

        if (auth()->guard('web')->check()) {
            $currentUser = auth()->guard('web')->user();
        } elseif (auth()->guard('cooperative')->check()) {
            $currentUser = auth()->guard('cooperative')->user();
        }

        $currentUserId = $currentUser->id;
        DB::statement(
            'CALL sp_member_payments_action(?,?,?,?,?,?,?,?,?)',
            [
                $request->action,
                $request->id,
                $request->member_id,
                $request->delivery_id,
                $request->amount,
                $request->payment_Date,
                $request->payment ?? 'CASH',
                $currentUserId,
                $request->status
            ]
        );
        return back()->with(
            'success',
            'Action ' . $request->action . ' performed successfully!'
        );
    }
}
