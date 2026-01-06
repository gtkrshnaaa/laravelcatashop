@extends('layouts.admin')

@section('title', 'Add New Banner')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-bold tracking-tight text-primary">Add New Banner</h1>
        <p class="text-secondary mt-2">Create a new slide for the homepage hero section.</p>
    </div>

    <div class="bg-surface border border-border rounded-xl p-6 shadow-sm">
        <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data">
            @include('admin.banners.form')
        </form>
    </div>
</div>
@endsection
