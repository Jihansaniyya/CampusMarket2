<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class SellerApprovalController extends Controller
{
    /**
     * Display a list of pending seller registrations
     */
    public function index()
    {
        $pendingSellers = User::where('role', 'seller')
            ->where('approval_status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();
            
        $approvedSellers = User::where('role', 'seller')
            ->where('approval_status', 'approved')
            ->orderBy('approved_at', 'desc')
            ->get();
            
        $rejectedSellers = User::where('role', 'seller')
            ->where('approval_status', 'rejected')
            ->orderBy('updated_at', 'desc')
            ->get();
        
        return view('admin.seller-approval.index', compact('pendingSellers', 'approvedSellers', 'rejectedSellers'));
    }
    
    /**
     * Show detailed information about a seller
     */
    public function show($id)
    {
        $seller = User::where('role', 'seller')->findOrFail($id);
        return view('admin.seller-approval.show', compact('seller'));
    }
    
    /**
     * Approve a seller registration
     */
    public function approve(Request $request, $id)
    {
        $seller = User::where('role', 'seller')->findOrFail($id);
        
        $seller->update([
            'approval_status' => 'approved',
            'approved_at' => now(),
            'rejection_reason' => null,
        ]);
        
        // TODO: Send email notification to seller
        
        return redirect()->route('admin.sellers.approval.index')
            ->with('success', 'Penjual ' . $seller->store_name . ' berhasil disetujui!');
    }
    
    /**
     * Reject a seller registration
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);
        
        $seller = User::where('role', 'seller')->findOrFail($id);
        
        $seller->update([
            'approval_status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
            'approved_at' => null,
        ]);
        
        // TODO: Send email notification to seller
        
        return redirect()->route('admin.sellers.approval.index')
            ->with('success', 'Penjual ' . $seller->store_name . ' ditolak.');
    }
}
