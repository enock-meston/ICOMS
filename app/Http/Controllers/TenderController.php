<?php

namespace App\Http\Controllers;

use App\Models\Tender;
use App\Models\ProcurementItem;
use Illuminate\Http\Request;

class TenderController extends Controller
{
    public function index()
    {
        $title = 'Tenders';
        $tenders = Tender::with('item')->orderBy('id', 'asc')->get();
        $items = ProcurementItem::all();

        return view('tender.index', compact('title', 'tenders', 'items'));
    }
}
