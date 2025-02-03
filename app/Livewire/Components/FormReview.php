<?php

namespace App\Livewire\Components;

use App\Models\OrderItem;
use App\Models\ProductVariant;
use App\Models\Review;
use App\Models\ReviewFile;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Masmerise\Toaster\Toaster;
use Illuminate\Support\Str;

class FormReview extends Component
{
    use WithFileUploads;

    public $productId;
    public $rating;
    public $description;
    public $files = [];

    public $existingReview;
    public $hasPurchased = false;

    public function mount($productId)
    {
        $this->productId = $productId;


        $this->existingReview = Review::where('product_id', $productId)
            ->where('user_id', auth()->id())
            ->first();

        if ($this->existingReview) {
            $this->rating = $this->existingReview->rating;
            $this->description = $this->existingReview->description;
        }

        $this->checkIfUserPurchased();
    }

    public function rules()
    {
        return [
            'rating' => 'required|integer|min:1|max:5',
            'description' => 'required|string|max:500',
            // 'files' => 'nullable|array',
            // 'files.*' => 'image|mimes:jpg,jpeg,png|max:2048',
        ];
    }


    public function messages()
    {
        return [
            'rating.required' => 'Rating harus diisi.',
            'rating.integer' => 'Rating harus berupa angka.',
            'rating.min' => 'Rating minimal adalah 1.',
            'rating.max' => 'Rating maksimal adalah 5.',
            'description.required' => 'Deskripsi ulasan tidak boleh kosong.',
            'description.max' => 'Deskripsi ulasan maksimal 500 karakter.',
            // 'files.*.image' => 'Setiap file harus berupa gambar.',
            // 'files.*.mimes' => 'Setiap file harus berupa gambar dengan format jpg, jpeg, atau png.',
            // 'files.*.max' => 'Ukuran setiap file tidak boleh lebih dari 2MB.',
        ];
    }

    public function setRating($value)
    {
        $this->rating = $value;
    }

    public function submit()
    {
        try {

            $this->validate();

            if ($this->existingReview) {
                // $this->existingReview->update([
                //     'rating' => $this->rating,
                //     'description' => $this->description,
                // ]);
                $review = $this->existingReview;

                Toaster::success('Review berhasil diperbarui.');
            } else {
                $review = Review::create([
                    'product_id' => $this->productId,
                    'user_id' => auth()->id(),
                    'rating' => $this->rating,
                    'description' => $this->description,
                ]);

                Toaster::success('Review berhasil dikirim.');
            }

            // Simpan file yang diunggah
            foreach ($this->files as $file) {
                // Buat nama file acak menggunakan UUID dan ekstensi asli file
                $fileExtension = pathinfo($file['path'], PATHINFO_EXTENSION);
                $fileName = Str::uuid() . '.' . $fileExtension;

                // Simpan file ke storage 'public/reviews'
                $storedPath = Storage::disk('public')->putFileAs('reviews', new File($file['path']), $fileName);

                ReviewFile::create([
                    'review_id' => $review->id,
                    'file_path' => $fileName,
                ]);
            }

            $this->existingReview = $review;

            $this->dispatch("refreshReviews");
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Tangani kesalahan validasi
            // Ambil semua pesan error
            $errors = $e->validator->errors()->toArray();
            dd($errors); // Lihat semua error
        }
    }

    public function removeFile($fileId)
    {
        try {
            // Temukan file yang ingin dihapus
            $file = ReviewFile::findOrFail($fileId);

            // Hapus file dari storage
            Storage::disk('public')->delete('reviews/' . $file->file_path);

            // Hapus file dari database
            $file->delete();

            // Refresh ulasan untuk memperbarui tampilan
            $this->existingReview->load('files');

            // Kirimkan pemberitahuan sukses
            Toaster::success('File berhasil dihapus.');

            // Kirim event untuk memperbarui tampilan
            $this->dispatch("refreshReviews");
        } catch (\Exception $e) {
            Toaster::error('Terjadi kesalahan saat menghapus file.');
        }
    }

    private function checkIfUserPurchased()
    {
        $userId = Auth::id();
        if (!$userId) {
            return;
        }

        $variantIds = ProductVariant::where('product_id', $this->productId)->pluck('id');

        $this->hasPurchased = OrderItem::whereHas('order', function ($query) use ($userId) {
            $query->where('user_id', $userId)->where('status', 'completed');
        })->whereIn('product_variant_id', $variantIds)->exists();
    }


    public function render()
    {
        return view('livewire.components.form-review', [
            'hasPurchased' => $this->hasPurchased
        ]);
    }
}
