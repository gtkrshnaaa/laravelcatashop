@csrf
<div class="grid grid-cols-1 md:grid-cols-2 gap-8">
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
    </div>

    <div class="space-y-6">
        <!-- Image -->
        <div class="space-y-2">
            <label for="image" class="text-sm font-medium text-secondary">Banner Image</label>
            <div class="border-2 border-dashed border-border rounded-xl p-8 text-center hover:border-primary/50 transition-colors relative group">
                <input type="file" name="image" id="image" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                    {{ isset($banner) ? '' : 'required' }}>
                <div class="space-y-2">
                    <div class="w-12 h-12 bg-surface rounded-full flex items-center justify-center mx-auto text-secondary">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                        </svg>
                    </div>
                    <p class="text-sm text-secondary">Click to upload or drag and drop</p>
                    <p class="text-xs text-secondary/70">PNG, JPG up to 2MB (Rec: 1200x600px)</p>
                </div>
                
                @if(isset($banner) && $banner->image)
                    <div class="mt-4 relative rounded-lg overflow-hidden border border-border">
                        <img src="{{ Storage::url($banner->image) }}" alt="Current Banner" class="w-full h-auto">
                        <div class="absolute inset-0 bg-black/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none">
                            <span class="text-white text-xs font-medium">Click to replace</span>
                        </div>
                    </div>
                @endif
            </div>
        </div>

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
