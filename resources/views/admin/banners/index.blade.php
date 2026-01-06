@extends('layouts.admin')

@section('title', 'Banners')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold tracking-tight text-primary">Banners</h1>
            <p class="text-secondary mt-2">Manage homepage hero sliders.</p>
        </div>
        <a href="{{ route('admin.banners.create') }}" class="bg-primary text-background px-4 py-2 rounded-lg font-medium text-sm hover:opacity-90 transition-opacity flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Add New Banner
        </a>
    </div>

    <div class="bg-surface border border-border rounded-xl overflow-hidden shadow-sm">
        <table class="w-full text-left text-sm">
            <thead>
                <tr class="border-b border-border bg-background/50">
                    <th class="px-6 py-4 font-medium text-secondary">Position</th>
                    <th class="px-6 py-4 font-medium text-secondary">Title & Subtitle</th>
                    <th class="px-6 py-4 font-medium text-secondary">Status</th>
                    <th class="px-6 py-4 font-medium text-secondary text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-border">
                @forelse($banners as $banner)
                    <tr class="hover:bg-background/50 transition-colors">
                        <td class="px-6 py-4 text-primary font-medium">
                            #{{ $banner->position }}
                        </td>
                        <td class="px-6 py-4 max-w-md">
                            <div class="font-medium text-primary line-clamp-1" title="{{ strip_tags($banner->title) }}">
                                {!! strip_tags($banner->title) !!}
                            </div>
                            <div class="text-xs text-secondary mt-1 line-clamp-1">
                                {{ $banner->subtitle }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($banner->is_active)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-900/30 text-green-400 border border-green-900/50">
                                    Active
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-900/30 text-red-400 border border-red-900/50">
                                    Inactive
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right flex justify-end gap-2">
                            <a href="{{ route('admin.banners.edit', $banner) }}" class="p-2 text-secondary hover:text-primary bg-background border border-border rounded-lg hover:border-primary transition-colors" title="Edit">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                </svg>
                            </a>
                            <form action="{{ route('admin.banners.destroy', $banner) }}" method="POST" onsubmit="return confirm('Delete this banner?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-red-500 hover:text-red-400 bg-background border border-border rounded-lg hover:border-red-500 transition-colors" title="Delete">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                    </svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-secondary">
                            No banners found. Create one to get started.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
