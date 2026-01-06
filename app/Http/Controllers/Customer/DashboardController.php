<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Display customer dashboard with recent orders.
     */
    public function index()
    {
        $customer = auth('customer')->user();
        
        $recentOrders = $customer->transactions()
            ->latest()
            ->take(10)
            ->get();

        $stats = [
            'total_orders' => $customer->transactions()->count(),
            'pending_orders' => $customer->transactions()->where('status', 'unpaid')->count(),
            'completed_orders' => $customer->transactions()->where('status', 'completed')->count(),
        ];

        return view('customer.dashboard.index', compact('recentOrders', 'stats'));
    }
}
