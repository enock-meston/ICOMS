<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Deliverie;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SupplierPaymentController extends Controller
{
    public function index()
    {
        $title    = "Supplier Payments";
        $Payments = DB::select('CALL sp_supplier_payments(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
            'SELECT_ALL', null, null, null, null, null, null, null, null, null
        ]);
        $Suppliers = Supplier::orderBy('supplier_name', 'asc')->get();
        $Contract = Contract::orderBy('id', 'asc')->get();
        $Deliveries = Deliverie::orderBy('id', 'asc')->get();

        return view('supplier-payment.index', compact('title', 'Payments', 'Suppliers', 'Contract', 'Deliveries'));
    }

    public function handleAction(Request $request)
    {
        // Validate input
        $request->validate([
            'action'       => 'required|in:INSERT,UPDATE,DELETE',
            'id'           => 'nullable|required_if:action,UPDATE,DELETE|integer',
            'contract_id'  => 'nullable|required_if:action,INSERT,UPDATE|integer',
            'supplier_id'  => 'nullable|required_if:action,INSERT,UPDATE|integer',
            'amount'       => 'nullable|required_if:action,INSERT,UPDATE|numeric',
            'payment_date' => 'nullable|required_if:action,INSERT,UPDATE|date',
            'channel'      => 'nullable|required_if:action,INSERT,UPDATE|in:BANK,CASH,MOBILE_MONEY,CHEQUE',
            'status'       => 'nullable|required_if:action,INSERT,UPDATE|string|max:50',
        ]);

        // Get current logged in user
        if (auth()->guard('web')->check()) {
            $currentUser = auth()->guard('web')->user();
        } elseif (auth()->guard('cooperative')->check()) {
            $currentUser = auth()->guard('cooperative')->user();
        }
        $currentUserId = $currentUser->id;

        DB::statement(
            'CALL sp_supplier_payments(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
            [
                $request->action,        // p_action
                $request->id,            // p_id
                $request->contract_id,   // p_contract_id
                $request->delivery_id,   // p_delivery_id (null for now)
                $request->supplier_id,   // p_supplier_id
                $request->amount,        // p_amount
                $request->payment_date,  // p_payment_date
                $request->channel,       // p_channel
                $currentUserId,          // p_approved_by_manager
                $request->status,        // p_status
            ]
        );

        return back()->with(
            'success',
            'Action ' . $request->action . ' performed successfully!'
        );
    }
}
