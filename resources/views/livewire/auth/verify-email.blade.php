<div class="flex min-h-screen items-center justify-center bg-gray-100">
    <div class="max-w-md rounded-lg bg-white p-8 text-center shadow-lg">
        <h2 class="mb-4 text-2xl font-semibold text-gray-800">Verifikasi Email Anda</h2>
        <p class="mb-6 text-gray-600">
            Kami telah mengirimkan tautan verifikasi ke alamat email Anda.
            Harap periksa email Anda dan klik tautan yang diberikan untuk memverifikasi akun Anda.
        </p>

        <div class="mt-6">
            <!-- Tombol Kirim Ulang Email Verifikasi -->
            <button wire:click="sendVerificationEmail" class="btn btn-primary w-full" wire:loading.attr="disabled">
                <!-- Teks saat loading -->
                <span wire:loading.remove> Kirim Ulang Email Verifikasi </span>
                <span wire:loading> Mengirim... </span>
            </button>
        </div>

        <!-- Pesan loading tambahan jika diinginkan -->
        <div wire:loading.flex class="mt-4 items-center justify-center">
            <div class="text-gray-600">Sedang memproses permintaan Anda...</div>
        </div>
    </div>
</div>
