<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Compost_input_expense;
use App\Models\Compost_group_production;
use App\Models\Compost_usage;
use App\Models\Member;
use Illuminate\Support\Facades\DB;


class CompostUsageController extends Controller
{
    //
    public function index()
    {
        $title = "Compost Usage";
        $Members = Member::orderBy('id', 'asc')->get();
        $Compostgroups = Compost_group_production::orderBy('id', 'asc')->get();
        $CompostUsage = Compost_usage::orderBy('id', 'asc')->get();
        return view('compostUsage.index', compact('title', 'Members', 'Compostgroups', 'CompostUsage'));
    }

    public function handleAction(Request $request)
    {
        $request->validate([
            'action'          => 'required|in:INSERT,UPDATE,DELETE',
            'id'              => 'nullable|required_if:action,UPDATE,DELETE|integer',
            'compost_id'      => 'nullable|required_if:action,INSERT,UPDATE|integer',
            'member_id'       => 'nullable|required_if:action,INSERT,UPDATE|integer',
            'qty_used_kg'     => 'nullable|required_if:action,INSERT,UPDATE|numeric',
            'price_per_kg'    => 'nullable|required_if:action,INSERT,UPDATE|numeric',
            'total_amount'    => 'nullable|required_if:action,INSERT,UPDATE|numeric',
            'payment_type'    => 'nullable|required_if:action,INSERT,UPDATE|string|max:50',
            'status'          => 'nullable|required_if:action,INSERT,UPDATE|string|max:50',
        ]);

        DB::statement(
            'CALL sp_compost_usages_action(?,?,?,?,?,?,?,?,?)',
            [
                $request->action,         // p_action
                $request->id,             // p_id
                $request->compost_id,     // p_compost_id
                $request->member_id,      // p_member_id
                $request->qty_used_kg,    // p_qty_used_kg
                $request->price_per_kg,   // p_price_per_kg
                $request->total_amount,   // p_total_amount
                $request->payment_type,   // p_payment_type
                $request->status          // p_status
            ]
        );

        return back()->with(
            'success',
            'Action ' . $request->action . ' performed successfully!'
        );
    }
}
