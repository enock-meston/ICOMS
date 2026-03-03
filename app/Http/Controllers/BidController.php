<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use App\Models\Tender;
use App\Models\Supplier;
use Illuminate\Http\Request;

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
}
