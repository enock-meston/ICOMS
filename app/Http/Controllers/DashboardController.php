<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Input_Allocation;
use App\Models\Member;
use App\Models\Rice_Delivery;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $title = 'Admin Dashboard';
        // count user
        $userCount = User::count();
        $memberCount = Member::count();
        $allocatedRecord = Input_Allocation::count();
        $deliveredRecord = Rice_Delivery::count();
        return view('admin.dashboard',compact('title', 'userCount', 'memberCount', 'allocatedRecord', 'deliveredRecord'));
    }
}
