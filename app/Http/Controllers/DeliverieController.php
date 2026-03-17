<?php

namespace App\Http\Controllers;

use App\Models\Committee;
use App\Models\Contract;
use App\Models\Deliverie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeliverieController extends Controller
{
    //
    public function index()
    {
        $title = 'Deliveries';
        $deliveries = Deliverie::with(['contract', 'receivingCommittee'])->orderBy('id', 'asc')->get();
        $contracts = Contract::orderBy('id', 'asc')->get();
        $committees = Committee::orderBy('id', 'asc')->get();

        return view('deliveries.index', compact('title', 'deliveries', 'contracts', 'committees'));
    }

    public function handleAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:INSERT,UPDATE,DELETE',
            'id' => 'nullable|required_if:action,UPDATE,DELETE|integer',
            'contract_id' => 'nullable|required_if:action,INSERT,UPDATE|integer',
            'delivery_date' => 'nullable|date',
            'delivery_description' => 'nullable|string',
            'quantity_received' => 'nullable|numeric',
            'value_received' => 'nullable|numeric',
            'receiving_committee_id' => 'nullable|integer',
            'grn_no' => 'nullable|string',
            'conformity_status' => 'nullable|string',
            'remarks' => 'nullable|string',
        ]);

        DB::statement(
            'CALL sp_deliveries_action(?,?,?,?,?,?,?,?,?,?,?)',
            [
                $request->action,
                $request->id,
                $request->contract_id,
                $request->delivery_date,
                $request->delivery_description,
                $request->quantity_received,
                $request->value_received,
                $request->receiving_committee_id,
                $request->grn_no,
                $request->conformity_status,
                $request->remarks
            ]
        );

        return back()->with('success', 'Action ' . $request->action . ' executed successfully!');
    }
}
