<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        $pendingSellersCount = User::where('role', 'seller')
            ->where('approval_status', 'pending')
            ->count();
            
        $approvedSellersCount = User::where('role', 'seller')
            ->where('approval_status', 'approved')
            ->count();
            
        $rejectedSellersCount = User::where('role', 'seller')
            ->where('approval_status', 'rejected')
            ->count();
            
        $totalUsers = User::count();
        
        return view('admin.dashboard', compact(
            'pendingSellersCount',
            'approvedSellersCount',
            'rejectedSellersCount',
            'totalUsers'
        ));
    }
}
