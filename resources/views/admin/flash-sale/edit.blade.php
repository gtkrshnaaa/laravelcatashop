@extends('layouts.admin')

@section('title', 'Flash Sale Settings')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-bold tracking-tight text-primary">Flash Sale Settings</h1>
        <p class="text-secondary mt-2">Configure weekly special offer section on homepage.</p>
    </div>

    <!-- Current Stats Card -->
    <div class="bg-surface border border-border rounded-xl p-6 shadow-sm">
        <h3 class="font-bold text-primary mb-4">This Week's Stats</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <p class="text-xs text-secondary uppercase tracking-wider mb-1">Slots Used</p>
                <p class="text-2xl font-bold text-primary">{{ $stats['used'] }}</p>
            </div>
            <div>
                <p class="text-xs text-secondary uppercase tracking-wider mb-1">Remaining</p>
                <p class="text-2xl font-bold {{ $stats['remaining'] > 10 ? 'text-green-500' : 'text-red-500' }}">{{ $stats['remaining'] }}</p>
            </div>
            <div>
                <p class="text-xs text-secondary uppercase tracking-wider mb-1">Weekly Limit</p>
                <p class="text-2xl font-bold text-primary">{{ $stats['total'] }}</p>
            </div>
        </div>
        <div class="mt-4">
            <div class="w-full bg-background border border-border rounded-full h-3 overflow-hidden">
                <div class="h-full bg-gradient-to-r from-orange-400 to-red-600 transition-all" style="width: {{ min(100, $stats['percentage']) }}%"></div>
            </div>
        </div>
    </div>

    <!-- Settings Form -->
    <div class="bg-surface border border-border rounded-xl p-6 shadow-sm">
        <form action="{{ route('admin.flashSale.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <!-- Status Toggle -->
                <div class="flex items-center justify-between pb-6 border-b border-border">
                    <div>
                        <label class="text-sm font-medium text-primary">Section Status</label>
                        <p class="text-xs text-secondary mt-1">Show/hide Flash Sale section on homepage</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" class="sr-only peer" {{ $settings->is_active ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-surface peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-primary rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-secondary after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary peer-checked:after:bg-background border border-border"></div>
                        <span class="ml-3 text-sm font-medium text-primary">{{ $settings->is_active ? 'Active' : 'Inactive' }}</span>
                    </label>
                </div>

                <!-- Title -->
                <div class="space-y-2">
                    <label for="title" class="text-sm font-medium text-secondary">Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $settings->title) }}" required
                        class="w-full bg-background border border-border rounded-lg px-4 py-2 text-primary focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all">
                </div>

                <!-- Badge Text -->
                <div class="space-y-2">
                    <label for="badge_text" class="text-sm font-medium text-secondary">Badge Text</label>
                    <input type="text" name="badge_text" id="badge_text" value="{{ old('badge_text', $settings->badge_text) }}" required
                        class="w-full bg-background border border-border rounded-lg px-4 py-2 text-primary focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all">
                </div>

                <!-- Description -->
                <div class="space-y-2">
                    <label for="description" class="text-sm font-medium text-secondary">Description</label>
                    <textarea name="description" id="description" rows="3" required
                        class="w-full bg-background border border-border rounded-lg px-4 py-2 text-primary focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all resize-none">{{ old('description', $settings->description) }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Weekly Limit -->
                    <div class="space-y-2">
                        <label for="weekly_limit" class="text-sm font-medium text-secondary">Weekly Limit</label>
                        <input type="number" name="weekly_limit" id="weekly_limit" value="{{ old('weekly_limit', $settings->weekly_limit) }}" required min="1"
                            class="w-full bg-background border border-border rounded-lg px-4 py-2 text-primary focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all">
                        <p class="text-xs text-secondary">Maximum number of sales per week</p>
                    </div>

                    <!-- Reset Day -->
                    <div class="space-y-2">
                        <label for="reset_day" class="text-sm font-medium text-secondary">Reset Day</label>
                        <select name="reset_day" id="reset_day" required
                            class="w-full bg-background border border-border rounded-lg px-4 py-2 text-primary focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all">
                            @foreach(['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'] as $day)
                                <option value="{{ $day }}" {{ $settings->reset_day === $day ? 'selected' : '' }}>{{ ucfirst($day) }}</option>
                            @endforeach
                        </select>
                        <p class="text-xs text-secondary">Day when counter resets</p>
                    </div>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-border flex justify-end gap-3">
                <a href="{{ route('admin.dashboard') }}" class="px-6 py-2.5 rounded-lg border border-border text-secondary hover:text-primary hover:bg-surface transition-colors">
                    Cancel
                </a>
                <button type="submit" class="bg-primary text-background px-6 py-2.5 rounded-lg font-medium hover:opacity-90 transition-opacity">
                    Save Settings
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
