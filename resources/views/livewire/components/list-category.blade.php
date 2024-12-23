<div class="scroll-snap-x horizontal-scrollbar rounded-scrollbar mb-10 flex gap-6 overflow-x-auto py-3">
    @foreach ($categories as $category)
        <a href="{{ route('front.products.category', $category) }}" wire:navigate
            class="{{ request()->is('products/category/' . $category->slug) ? 'shadow font-bold' : '' }} scroll-snap-align-start flex flex-shrink-0 items-center justify-center gap-3 rounded-full bg-primary px-6 py-2 text-sm hover:translate-x-1 hover:scale-105 hover:shadow md:text-base"
            onmouseover="scrollIntoViewIfNeeded(this)">
            <img src="{{ $category->icon ? Storage::url($category->icon) : asset('images/laravel.svg') }}" alt="Icon"
                class="md:max-w-10 max-w-8 max-h-8 object-cover md:max-h-10">
            <div class="text-white"> {{ $category->name }}</div>
        </a>
    @endforeach
</div>

@push('after-script')
    <script type="module">
        function scrollIntoViewIfNeeded(element) {
            const parent = element.parentElement;
            const parentRect = parent.getBoundingClientRect();
            const elementRect = element.getBoundingClientRect();

            if (elementRect.left < parentRect.left || elementRect.right > parentRect.right) {
                element.scrollIntoView({
                    behavior: 'smooth',
                    inline: 'center'
                });
            }
        }
    </script>
@endpush
