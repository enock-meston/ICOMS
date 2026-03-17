<?php

namespace App\Http\Controllers;

use App\Models\Tender;
use App\Models\Committee;
use App\Models\Supplier;
use App\Models\TenderEvaluation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TenderEvaluationController extends Controller
{
    public function index()
    {
        $title       = "Tender Evaluations";
        $Evaluations = DB::select('CALL sp_tender_evaluations(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
            'SELECT_ALL', null, null, null, null, null, null, null, null, null, null
        ]);
        $Tenders    = Tender::orderBy('id', 'desc')->get();
        $Committees = Committee::where('status', 'ACTIVE')->get();
        $Suppliers  = Supplier::orderBy('supplier_name', 'asc')->get();

        return view('tender-evaluation.index', compact(
            'title', 'Evaluations', 'Tenders', 'Committees', 'Suppliers'
        ));
    }

    public function handleAction(Request $request)
    {
        // Validate input
        $request->validate([
            'action'                  => 'required|in:INSERT,UPDATE,DELETE',
            'id'                      => 'nullable|required_if:action,UPDATE,DELETE|integer',
            'tender_id'               => 'nullable|required_if:action,INSERT,UPDATE|integer',
            'committee_id'            => 'nullable|required_if:action,INSERT,UPDATE|integer',
            'evaluation_date'         => 'nullable|required_if:action,INSERT,UPDATE|date',
            'report_file'             => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'recommended_supplier_id' => 'nullable|integer',
            'recommended_amount'      => 'nullable|numeric',
            'status'                  => 'nullable|string|max:50',
        ]);

        // Get current logged in user
        if (auth()->guard('web')->check()) {
            $currentUser = auth()->guard('web')->user();
        } elseif (auth()->guard('cooperative')->check()) {
            $currentUser = auth()->guard('cooperative')->user();
        }
        $currentUserId = $currentUser->id;

        // Handle file upload
        $reportFile = null;
        if ($request->hasFile('report_file')) {
            $reportFile = $request->file('report_file')
                                   ->store('tender-evaluations/reports', 'public');
        } elseif ($request->action === 'UPDATE') {
            // Keep existing file if no new file uploaded
            $existing   = DB::select('CALL sp_tender_evaluations(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
                'SELECT', $request->id, null, null, null, null, null, null, null, null, null
            ]);
            $reportFile = $existing[0]->report_file ?? null;
        }

        DB::statement(
            'CALL sp_tender_evaluations(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
            [
                $request->action,                  // p_action
                $request->id,                      // p_id
                $request->tender_id,               // p_tender_id
                $request->committee_id,            // p_committee_id
                $request->evaluation_date,         // p_evaluation_date
                $reportFile,                       // p_report_file
                $request->recommended_supplier_id, // p_recommended_supplier_id
                $request->recommended_amount,      // p_recommended_amount
                null,                              // p_approved_by_manager (handled separately)
                null,                              // p_approved_by_board (handled separately)
                $request->status ?? 'PENDING',     // p_status
            ]
        );

        return back()->with(
            'success',
            'Action ' . $request->action . ' performed successfully!'
        );
    }
}