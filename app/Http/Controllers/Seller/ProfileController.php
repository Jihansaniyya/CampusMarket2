<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Display seller profile page.
     */
    public function index()
    {
        $seller = Auth::user();
        
        return view('seller.profile', compact('seller'));
    }
}
