<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FlashSaleSetting;
use Illuminate\Http\Request;

class FlashSaleSettingController extends Controller
{
    public function edit()
    {
        $settings = FlashSaleSetting::getSettings();
        $stats = $settings->getSlotStats();
        
        return view('admin.flash-sale.edit', compact('settings', 'stats'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'is_active' => 'boolean',
            'title' => 'required|string|max:255',
            'badge_text' => 'required|string|max:255',
            'description' => 'required|string',
            'weekly_limit' => 'required|integer|min:1',
            'reset_day' => 'required|string|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $settings = FlashSaleSetting::getSettings();
        $settings->update($validated);

        return redirect()->route('admin.flashSale.edit')->with('success', 'Flash Sale settings updated successfully.');
    }
}
