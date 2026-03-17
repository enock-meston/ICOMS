<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SupplierController extends Controller
{
   public function index()
{
    $title     = "Suppliers";
    $suppliers = DB::select('CALL sp_suppliers(?, ?, ?, ?, ?, ?, ?, ?, ?)', [
        'SELECT_ALL', null, null, null, null, null, null, null, null
    ]);
    return view('supplier.index', compact('title', 'suppliers'));
}
    public function handleAction(Request $request)
    {
        // Validate input
        $request->validate([
            'action'        => 'required|in:INSERT,UPDATE,DELETE',
            'id'            => 'nullable|required_if:action,UPDATE,DELETE|integer',
            'supplier_name' => 'nullable|required_if:action,INSERT,UPDATE|string|max:255',
            'tin'           => 'nullable|required_if:action,INSERT,UPDATE|string|max:100',
            'phone'         => 'nullable|string|max:50',
            'email'         => 'nullable|email|max:255',
            'address'       => 'nullable|string',
            'bank_name'     => 'nullable|string|max:255',
            'bank_account'  => 'nullable|string|max:100',
        ]);

        if (auth()->guard('web')->check()) {
            $currentUser = auth()->guard('web')->user();
        } elseif (auth()->guard('cooperative')->check()) {
            $currentUser = auth()->guard('cooperative')->user();
        }
        $currentUserId = $currentUser->id;

        DB::statement(
            'CALL sp_suppliers(?, ?, ?, ?, ?, ?, ?, ?, ?)',
            [
                $request->action,         // p_action
                $request->id,             // p_id
                $request->supplier_name,  // p_supplier_name
                $request->tin,            // p_tin
                $request->address,        // p_address
                $request->phone,          // p_phone
                $request->email,          // p_email
                $request->bank_name,      // p_bank_name
                $request->bank_account,   // p_bank_account
            ]
        );

        return back()->with(
            'success',
            'Action ' . $request->action . ' performed successfully!'
        );
    }
}