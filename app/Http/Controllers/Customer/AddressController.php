<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\CustomerAddress;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    /**
     * Display all customer addresses.
     */
    public function index()
    {
        $addresses = auth('customer')->user()->addresses;
        return view('customer.addresses.index', compact('addresses'));
    }

    /**
     * Show form to create new address.
     */
    public function create()
    {
        return view('customer.addresses.create');
    }

    /**
     * Store new address.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'label' => ['required', 'string', 'max:100'],
            'address' => ['required', 'string'],
            'is_default' => ['boolean'],
        ]);

        $validated['customer_id'] = auth('customer')->id();
        $validated['is_default'] = $request->filled('is_default');

        CustomerAddress::create($validated);

        return redirect()->route('customer.addresses.index')->with('success', 'Address added successfully.');
    }

    /**
     * Show form to edit address.
     */
    public function edit(CustomerAddress $address)
    {
        // Ensure customer can only edit their own address
        if ($address->customer_id !== auth('customer')->id()) {
            abort(403, 'Unauthorized access to this address.');
        }

        return view('customer.addresses.edit', compact('address'));
    }

    /**
     * Update address.
     */
    public function update(Request $request, CustomerAddress $address)
    {
        // Ensure customer can only update their own address
        if ($address->customer_id !== auth('customer')->id()) {
            abort(403, 'Unauthorized access to this address.');
        }

        $validated = $request->validate([
            'label' => ['required', 'string', 'max:100'],
            'address' => ['required', 'string'],
            'is_default' => ['boolean'],
        ]);

        $validated['is_default'] = $request->filled('is_default');

        $address->update($validated);

        return redirect()->route('customer.addresses.index')->with('success', 'Address updated successfully.');
    }

    /**
     * Delete address.
     */
    public function destroy(CustomerAddress $address)
    {
        // Ensure customer can only delete their own address
        if ($address->customer_id !== auth('customer')->id()) {
            abort(403, 'Unauthorized access to this address.');
        }

        $address->delete();

        return redirect()->route('customer.addresses.index')->with('success', 'Address deleted successfully.');
    }

    /**
     * Set address as default.
     */
    public function setDefault(CustomerAddress $address)
    {
        // Ensure customer can only set their own address as default
        if ($address->customer_id !== auth('customer')->id()) {
            abort(403, 'Unauthorized access to this address.');
        }

        $address->update(['is_default' => true]);

        return back()->with('success', 'Default address updated.');
    }
}
