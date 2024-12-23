<div class="flex min-h-screen items-center justify-center bg-gray-100">
    <div class="mt-[60px] w-full max-w-sm rounded-lg bg-white p-8 shadow-lg lg:mt-[70px]">
        <div class="mb-5 flex flex-col items-center justify-center gap-3">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/laravel.svg') }}" alt="Brand Logo" class="h-16 w-16">
                <h2 class="text-2xl font-semibold">Olsop</h2>
            </div>
            <h2 class="text-xl font-semibold text-slate-600">Forgot Password</h2>
        </div>

        <div wire:loading.delay.longer class="alert alert-primary mb-4 flex items-center gap-4" role="alert">
            <div class="flex items-center gap-2">
                <span class="alert-icon">
                    <span class="size-5 icon-[tabler--alert-triangle] mt-1"></span>
                </span>
                <p> Sedang mengirimkan email.... </p>
            </div>

            <div class="size-full absolute start-0 top-0 bg-base-100/50"></div>

            <div class="absolute start-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 transform">
                <span class="loading loading-spinner"></span>
            </div>
        </div>

        <form wire:submit.prevent="submit">
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input wire:model="email" type="email" id="email"
                    class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Email">
                @error('email')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div class="relative">
                <button type="submit"
                    class="w-full rounded-md bg-blue-500 py-2 font-semibold text-white hover:bg-blue-600 focus:outline-none"
                    wire:loading.attr="disabled">
                    Reset Password
                </button>
            </div>

            <div class="mt-5 space-y-2.5 text-center">
                <p class="text-sm">Belum punya akun?<a href="{{ route('front.register') }}"
                        class="ml-1 text-sm text-blue-500 hover:underline" wire:navigate>Daftar
                        disini</a></p>
            </div>
        </form>
    </div>
</div>
