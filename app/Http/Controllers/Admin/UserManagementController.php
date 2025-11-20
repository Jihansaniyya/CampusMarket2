<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\View\View;

class UserManagementController extends Controller
{
    /**
     * Display a listing of all users for administrators.
     */
    public function index(): View
    {
        $users = User::latest()->paginate(12);

        return view('admin.users.index', [
            'users' => $users,
        ]);
    }
}
