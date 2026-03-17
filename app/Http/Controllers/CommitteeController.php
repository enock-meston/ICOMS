<?php

namespace App\Http\Controllers;

use App\Models\Committee;
use Illuminate\Http\Request; // ✅ THIS WAS MISSING

class CommitteeController extends Controller
{
    public function index()
    {
        $title      = "Committees";
        $Committees = Committee::all();
        return view('committee.index', compact('title', 'Committees'));
    }

    public function handleAction(Request $request)
    {
        $request->validate([
            'action'         => 'required|in:INSERT,UPDATE,DELETE',
            'id'             => 'nullable|required_if:action,UPDATE,DELETE|integer',
            'committee_name' => 'nullable|required_if:action,INSERT,UPDATE|string|max:255',
            'committee_type' => 'nullable|required_if:action,INSERT,UPDATE|string|max:100',
            'start_date'     => 'nullable|required_if:action,INSERT,UPDATE|date',
            'end_date'       => 'nullable|required_if:action,INSERT,UPDATE|date',
            'status'         => 'nullable|required_if:action,INSERT,UPDATE|string|max:50',
        ]);

        if ($request->action === 'INSERT') {
            Committee::create([
                'committee_name' => $request->committee_name,
                'committee_type' => $request->committee_type,
                'start_date'     => $request->start_date,
                'end_date'       => $request->end_date,
                'status'         => $request->status,
            ]);
        } elseif ($request->action === 'UPDATE') {
            $committee = Committee::findOrFail($request->id);
            $committee->update([
                'committee_name' => $request->committee_name,
                'committee_type' => $request->committee_type,
                'start_date'     => $request->start_date,
                'end_date'       => $request->end_date,
                'status'         => $request->status,
            ]);
        } elseif ($request->action === 'DELETE') {
            $committee = Committee::findOrFail($request->id);
            $committee->delete();
        }

        return back()->with(
            'success',
            'Action ' . $request->action . ' performed successfully!'
        );
    }
}