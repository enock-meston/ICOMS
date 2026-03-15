<?php

namespace App\Http\Controllers;

use App\Models\Compost_input_expense;
use App\Models\Compost_group_production;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CompostInputExpenseController extends Controller
{
    //
    public function index()
    {
        $title = "Compost input";
        $CompostInput = Compost_input_expense::orderBy('id', 'desc')->get();
        $Compostgroups = Compost_group_production::orderBy('id', 'asc')->get();
        return view('compostinput.index', compact('title', 'CompostInput', 'Compostgroups'));
    }

    public function handleAction(Request $request)
    {
        $request->validate([
            'action'        => 'required|in:INSERT,UPDATE,DELETE',
            'id'            => 'nullable|required_if:action,UPDATE,DELETE|integer',
            'compost_id'    => 'nullable|required_if:action,INSERT,UPDATE|integer',
            'expense_type'  => 'nullable|required_if:action,INSERT,UPDATE|string|max:100',
            'amount'        => 'nullable|required_if:action,INSERT,UPDATE|numeric',
            'provided_by'   => 'nullable|required_if:action,INSERT,UPDATE|string|max:255',
            'date'          => 'nullable|required_if:action,INSERT,UPDATE|date'
        ]);

        DB::statement(
            'CALL sp_compost_input_expenses_action(?,?,?,?,?,?,?)',
            [
                $request->action,       // p_action
                $request->id,           // p_id
                $request->compost_id,   // p_compost_id
                $request->expense_type, // p_expense_type
                $request->amount,       // p_amount
                $request->provided_by,  // p_provided_by
                $request->date          // p_date
            ]
        );

        return back()->with('success', 'Action ' . $request->action . ' executed successfully');
    }


}
