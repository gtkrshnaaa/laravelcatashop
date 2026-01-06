@extends('layouts.admin')

@section('title', 'Edit Banner')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-bold tracking-tight text-primary">Edit Banner</h1>
        <p class="text-secondary mt-2">Update banner details and image.</p>
    </div>

    <div class="bg-surface border border-border rounded-xl p-6 shadow-sm">
        <form action="{{ route('admin.banners.update', $banner) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('admin.banners.form')
        </form>
    </div>
</div>
@endsection
