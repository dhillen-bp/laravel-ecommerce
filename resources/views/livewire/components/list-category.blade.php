<div class="mb-10 flex justify-center gap-6">
    @foreach ($categories as $category)
        <a href="{{ route('front.products.category', $category) }}" wire:navigate
            class="{{ request()->is('products/category/' . $category->slug) ? 'shadow-lg font-bold' : '' }} flex items-center justify-center gap-3 rounded-full bg-primary px-6 py-2 hover:scale-105 hover:shadow-lg">
            <img src="{{ $category->icon ? Storage::url($category->icon) : asset('images/laravel.svg') }}" alt="Icon"
                class="max-w-10 max-h-10 object-cover">
            <div class="text-white"> {{ $category->name }}</div>
        </a>
    @endforeach
</div>
