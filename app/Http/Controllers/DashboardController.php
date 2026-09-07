<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function adminDashboard()
    {
        $data = [
            'totalBooks' => \App\Models\Book::count(),
            'totalMembers' => \App\Models\Member::count(),
            'availableBooks' => \App\Models\Book::sum('jumlah_tersedia'),
            'borrowedBooks' => \App\Models\Transaction::where('status', 'dipinjam')->count(),
            'totalTransactions' => \App\Models\Transaction::count(),
            'activeTransactions' => \App\Models\Transaction::where('status', 'dipinjam')->count(),
            'lateTransactions' => \App\Models\Transaction::where('status', 'terlambat')->count(),
            'recentTransactions' => \App\Models\Transaction::with(['book', 'member', 'user'])
                ->latest()
                ->take(10)
                ->get(),
        ];

        return view('admin.dashboard', $data);
    }

    public function userDashboard()
    {
        $user = auth()->user();

        $data = [
            'availableBooks' => \App\Models\Book::where('jumlah_tersedia', '>', 0)->count(),
            'myActiveLoans' => \App\Models\Transaction::where('user_id', $user->id)
                ->where('status', 'dipinjam')
                ->with(['book', 'member'])
                ->get(),
            'myTransactions' => \App\Models\Transaction::where('user_id', $user->id)
                ->with(['book', 'member'])
                ->latest()
                ->take(10)
                ->get(),
            'lateLoans' => \App\Models\Transaction::where('user_id', $user->id)
                ->where('status', 'terlambat')
                ->count(),
        ];

        return view('user.dashboard', $data);
    }
}
