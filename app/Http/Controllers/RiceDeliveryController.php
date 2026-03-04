<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Rice_Delivery;
use App\Models\Input_Allocation;
use App\Models\Season;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// use App\Http\Controllers\Controller\send_SMS;

class RiceDeliveryController extends Controller
{
    //
    public function index()
    {
        $title = "Rice Delivery";
        $RiceDeliveries = Rice_Delivery::orderBy('id', 'desc')->get();
        $Members = Member::all();
        $Seasons = Season::all();
        $InputAllocations = Input_Allocation::orderBy('created_at', 'DESC')->get();
        return view('riceDelivery.index', compact('title', 'RiceDeliveries', 'Members', 'Seasons', 'InputAllocations'));
    }


    public function getAllocations($id)
    {
        $allocations = Input_Allocation::where('member_id', $id)->get();
        return response()->json($allocations);
    }

    public function handleAction(Request $request)
    {
        // Validate input
        $request->validate([
            'action'            => 'required|in:INSERT,UPDATE,DELETE',
            'id'                => 'nullable|required_if:action,UPDATE,DELETE|integer',

            'member_id'         => 'nullable|required_if:action,INSERT,UPDATE|integer',
            'season_id'         => 'nullable|required_if:action,INSERT,UPDATE|integer',
            'Delivery_Date'     => 'nullable|required_if:action,INSERT,UPDATE|date',
            'Quantity_KG'       => 'nullable|required_if:action,INSERT,UPDATE|numeric',
            'Quality_Grade'     => 'nullable|required_if:action,INSERT,UPDATE|string|max:50',
            'Unit_Price'        => 'nullable|required_if:action,INSERT,UPDATE|numeric',
            'Gross_Value'       => 'nullable|required_if:action,INSERT,UPDATE|numeric',
            'Loan_Deduction'    => 'nullable|required_if:action,INSERT,UPDATE|numeric',
            'Other_Deductions'  => 'nullable|required_if:action,INSERT,UPDATE|numeric',
            'Net_Payable'       => 'nullable|required_if:action,INSERT,UPDATE|numeric',
        ]);

        if (auth()->guard('web')->check()) {
            $currentUser = auth()->guard('web')->user();
        } elseif (auth()->guard('cooperative')->check()) {
            $currentUser = auth()->guard('cooperative')->user();
        }
        $currentUserId = $currentUser->id;

        // select member phone number
        $member = Member::find($request->member_id);
        $phoneNumber = $member ? $member->phone : null;
        $names = $member ? $member->names : null;

        DB::statement(
            'CALL sp_rice_deliveries_action(?,?,?,?,?,?,?,?,?,?,?,?,?)',
            [
                $request->action,          // p_action
                $request->id,              // p_id
                $request->member_id,       // p_member_id
                $request->season_id,       // p_season_id
                $request->Delivery_Date,   // p_Delivery_Date
                $request->Quantity_KG,     // p_Quantity_KG
                $request->Quality_Grade,   // p_Quality_Grade
                $request->Unit_Price,      // p_Unit_Price
                $request->Gross_Value,     // p_Gross_Value
                $request->Loan_Deduction,  // p_Loan_Deduction
                $request->Other_Deductions, // p_Other_Deductions
                $request->Net_Payable,     // p_Net_Payable
                $currentUserId              // p_Created_By
            ]
        );

        // send sms function here

        $result = $this->send_SMS($phoneNumber, $names, $request->Net_Payable);
        // dd($result);
        // exit;
        return back()->with(
            'success',
            'Action ' . $request->action . ' performed successfully!  and ' . $result['status']
        );
    }


}
