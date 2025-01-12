<div class="mt-4">

    <form wire:submit="submit">
        <h3 class="text-lg font-semibold">
            {{ $existingReview ? 'Ubah Ulasan Saya' : 'Tambah Ulasan' }}
        </h3>
        <div class="mt-4">
            <label for="rating" class="block text-sm font-medium text-gray-700">Rating</label>
            <div class="flex items-center space-x-2">
                @for ($i = 1; $i <= 5; $i++)
                    <span wire:click="setRating({{ $i }})"
                        class="{{ $rating >= $i ? 'icon-[tabler--star-filled]' : 'icon-[tabler--star]' }} size-7 cursor-pointer bg-warning md:size-5">
                    </span>
                @endfor

            </div>
            @error('rating')
                <span class="text-red-500">{{ $message }}</span>
            @enderror
        </div>


        <div class="mt-4">
            <label for="description" class="block text-sm font-medium text-gray-700">Komentar</label>
            <textarea class="textarea" id="description" wire:model="description"></textarea>
            @error('description')
                <span class="text-red-500">{{ $message }}</span>
            @enderror
        </div>

        {{-- UPLOAD FILE --}}
        <div class="mt-4">
            <label for="file" class="block text-sm font-medium text-gray-700">Upload File</label>
            <livewire:dropzone wire:model="files" :rules="['image', 'mimes:png,jpeg,jpg', 'max:2048']" :multiple="true" />
            @error('files.*')
                <span class="text-red-500">{{ $message }}</span>
            @enderror
        </div>

        @if ($existingReview && $existingReview->files->count())
            <div class="mt-4">
                <h4 class="text-sm font-medium text-gray-700">Files Uploaded</h4>
                <div class="flex space-x-2">
                    @foreach ($existingReview->files as $file)
                        <div class="relative">
                            <img src="{{ Storage::url('reviews/' . $file->file_path) }}" alt="Review File"
                                class="h-20 w-20 rounded-lg object-cover">

                            <!-- Icon trash di kanan atas -->
                            <span
                                class="icon-[tabler--trash] absolute right-0 top-0 size-5 cursor-pointer text-slate-50 hover:text-red-800"
                                wire:click="removeFile({{ $file->id }})">
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif


        <button type="submit" class="mt-4 rounded bg-blue-600 px-4 py-2 text-white">Kirim Ulasan</button>
    </form>

</div>
