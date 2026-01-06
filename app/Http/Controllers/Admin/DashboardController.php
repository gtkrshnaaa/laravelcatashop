<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    /**
     * Display admin dashboard with metrics.
     */
    public function index()
    {
        // Real-time metrics (no cache for instant updates)
        $metrics = [
            'total_categories' => Category::count(),
            'total_products' => Product::count(),
            'total_transactions' => Transaction::count(),
            'pending_transactions' => Transaction::where('status', 'unpaid')->count(),
            'total_revenue' => Transaction::whereIn('status', ['paid', 'shipped', 'completed'])
                ->sum('amount_total'),
        ];

        $recentOrders = Transaction::with('items.product')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard.index', compact('metrics', 'recentOrders'));
    }
}
