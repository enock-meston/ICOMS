<?php
namespace App\Http\Controllers;

use App\Models\Tender;
use Illuminate\Http\Request;

class TenderController extends Controller
{
    public function index()
    {
        $title   = "Tenders";
        $tenders = Tender::orderBy('id', 'desc')->get();
        return view('tender.index', compact('title', 'tenders'));
    }

    public function handleAction(Request $request)
    {
        $request->validate([
            'action'             => 'required|in:INSERT,UPDATE,DELETE',
            'id'                 => 'nullable|required_if:action,UPDATE,DELETE|integer',
            'tender_ref_no'      => 'nullable|required_if:action,INSERT,UPDATE|string|max:255',
            'title'              => 'nullable|required_if:action,INSERT,UPDATE|string|max:255',
            'procurement_method' => 'nullable|required_if:action,INSERT,UPDATE|in:OPEN_TENDER,RFQ,DIRECT,OTHER',
            'publish_date'       => 'nullable|required_if:action,INSERT,UPDATE|date',
            'closing_date'       => 'nullable|required_if:action,INSERT,UPDATE|date',
            'status'             => 'nullable|required_if:action,INSERT,UPDATE|in:PLANNED,PUBLISHED,UNDER_EVALUATION,CLOSED,AWARDED',
            'notice_file'        => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        if (auth()->guard('web')->check()) {
            $currentUser = auth()->guard('web')->user();
        } elseif (auth()->guard('cooperative')->check()) {
            $currentUser = auth()->guard('cooperative')->user();
        }
        $currentUserId = $currentUser->id;

        $noticeFile = null;
        if ($request->hasFile('notice_file')) {
            $noticeFile = $request->file('notice_file')->store('tenders/notices', 'public');
        }

        if ($request->action === 'INSERT') {
            Tender::create([
                'tender_ref_no'      => $request->tender_ref_no,
                'title'              => $request->title,
                'procurement_method' => $request->procurement_method,
                'publish_date'       => $request->publish_date,
                'closing_date'       => $request->closing_date,
                'status'             => $request->status,
                'created_by'         => $currentUserId,
                'notice_file'        => $noticeFile,
            ]);

        } elseif ($request->action === 'UPDATE') {
            $tender = Tender::findOrFail($request->id);
            if ($request->hasFile('notice_file')) {
                $noticeFile = $request->file('notice_file')->store('tenders/notices', 'public');
            } else {
                $noticeFile = $tender->notice_file;
            }
            $tender->update([
                'tender_ref_no'      => $request->tender_ref_no,
                'title'              => $request->title,
                'procurement_method' => $request->procurement_method,
                'publish_date'       => $request->publish_date,
                'closing_date'       => $request->closing_date,
                'status'             => $request->status,
                'notice_file'        => $noticeFile,
            ]);

        } elseif ($request->action === 'DELETE') {
            $tender = Tender::findOrFail($request->id);
            $tender->delete();
        }

        return back()->with('success', 'Action ' . $request->action . ' performed successfully!');
    }
}