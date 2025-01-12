<div>
    <h3 class="text-lg font-semibold">Riwayat Ulasan</h3>
    @forelse ($reviews as $review)
        <div class="my-4 rounded-lg border p-4">
            <div class="flex items-center justify-between">
                <h4 class="text-lg font-semibold text-gray-800">{{ $review->user->name }}</h4>
                <span class="text-yellow-500">
                    {{ str_repeat('⭐', $review->rating) }}
                </span>
            </div>
            <p class="mt-2 text-gray-600">{{ $review->description }}</p>
            @if ($review->files->count())
                <div class="mt-4 flex space-x-4">
                    @foreach ($review->files as $file)
                        <img src="{{ Storage::url('reviews/' . $file->file_path) }}" alt="Review File"
                            class="h-20 w-20 rounded-lg object-cover">
                    @endforeach
                </div>
            @endif

        </div>
    @empty
        <p class="text-gray-600">Belum ada ulasan untuk produk ini.</p>
    @endforelse
</div>
