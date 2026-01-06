@csrf
<div class="space-y-6">
    <!-- Title -->
    <div class="space-y-2">
        <label for="title" class="text-sm font-medium text-secondary">Title (HTML Supported)</label>
        <textarea name="title" id="title" rows="3" required
            class="w-full bg-background border border-border rounded-lg px-4 py-2 text-primary focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all resize-none placeholder-secondary/50">{{ old('title', $banner->title ?? '') }}</textarea>
        <p class="text-xs text-secondary">
            Use &lt;br&gt; for line breaks. Wrap 2nd line in &lt;span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-blue-600"&gt;...&lt;/span&gt; for gradient effect.
        </p>
    </div>

    <!-- Subtitle -->
    <div class="space-y-2">
        <label for="subtitle" class="text-sm font-medium text-secondary">Subtitle</label>
        <textarea name="subtitle" id="subtitle" rows="2"
            class="w-full bg-background border border-border rounded-lg px-4 py-2 text-primary focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all resize-none placeholder-secondary/50">{{ old('subtitle', $banner->subtitle ?? '') }}</textarea>
    </div>

    <!-- Button Text -->
    <div class="space-y-2">
        <label for="button_text" class="text-sm font-medium text-secondary">Button Text</label>
        <input type="text" name="button_text" id="button_text" value="{{ old('button_text', $banner->button_text ?? '') }}"
            class="w-full bg-background border border-border rounded-lg px-4 py-2 text-primary focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all"
            placeholder="e.g. Shop Now">
    </div>

    <!-- Link -->
    <div class="space-y-2">
        <label for="link" class="text-sm font-medium text-secondary">Link URL</label>
        <input type="text" name="link" id="link" value="{{ old('link', $banner->link ?? '') }}"
            class="w-full bg-background border border-border rounded-lg px-4 py-2 text-primary focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all"
            placeholder="e.g. /catalog?category=electronics">
    </div>

    <div class="grid grid-cols-2 gap-6">

    <div class="space-y-6">
        <div class="grid grid-cols-2 gap-6">
            <!-- Position -->
            <div class="space-y-2">
                <label for="position" class="text-sm font-medium text-secondary">Position Order</label>
                <input type="number" name="position" id="position" value="{{ old('position', $banner->position ?? 1) }}"
                    class="w-full bg-background border border-border rounded-lg px-4 py-2 text-primary focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all">
            </div>

            <!-- Status -->
            <div class="space-y-2">
                <label class="text-sm font-medium text-secondary">Status</label>
                <div class="flex items-center gap-3 h-[42px]">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" class="sr-only peer" 
                            {{ old('is_active', $banner->is_active ?? true) ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-surface peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-primary rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-secondary after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary peer-checked:after:bg-background"></div>
                        <span class="ml-3 text-sm font-medium text-primary">Active</span>
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mt-8 pt-6 border-t border-border flex justify-end gap-3">
    <a href="{{ route('admin.banners.index') }}" class="px-6 py-2.5 rounded-lg border border-border text-secondary hover:text-primary hover:bg-surface transition-colors">
        Cancel
    </a>
    <button type="submit" class="bg-primary text-background px-6 py-2.5 rounded-lg font-medium hover:opacity-90 transition-opacity">
        {{ isset($banner) ? 'Update Banner' : 'Create Banner' }}
    </button>
</div>
