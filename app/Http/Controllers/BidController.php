<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use App\Models\Supplier;
use App\Models\Tender;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BidController extends Controller
{
    public function index()
    {
        $title = 'Bids';
        $bids = Bid::with(['tender', 'supplier'])->orderBy('id', 'asc')->get();
        // Assuming we might need these for the modal (UI placeholders)
        $tenders = Tender::all();
        $suppliers = Supplier::all();

        return view('bid.index', compact('title', 'bids', 'tenders', 'suppliers'));
    }

    public function handleAction(Request $request)
{
    $request->validate([
        'action' => 'required|in:INSERT,UPDATE,DELETE',
        'id' => 'nullable|required_if:action,UPDATE,DELETE|integer',
        'tender_id' => 'nullable|required_if:action,INSERT,UPDATE|integer',
        'supplier_id' => 'nullable|required_if:action,INSERT,UPDATE|integer',
        'bid_amount' => 'nullable|required_if:action,INSERT,UPDATE|numeric',
        'technical_score' => 'nullable|numeric',
        'financial_score' => 'nullable|numeric',
        'overall_score' => 'nullable|numeric',
        'evaluation_result' => 'nullable|string',
        'recommendation' => 'nullable|string',
        'submitted_at' => 'nullable|date',
    ]);

    if (auth()->guard('web')->check()) {
        $currentUser = auth()->guard('web')->user();
    } elseif (auth()->guard('cooperative')->check()) {
        $currentUser = auth()->guard('cooperative')->user();
    }

    $currentUserId = $currentUser->id;

    DB::statement(
        'CALL sp_bids_action(?,?,?,?,?,?,?,?,?,?,?)',
        [
            $request->action,
            $request->id,
            $request->tender_id,
            $request->supplier_id,
            $request->bid_amount,
            $request->technical_score,
            $request->financial_score,
            $request->overall_score,
            $request->evaluation_result,
            $request->recommendation,
            $request->submitted_at
        ]
    );

    return back()->with(
        'success',
        'Action ' . $request->action . ' executed successfully!'
    );
}
}
