<div class="flex min-h-screen items-center justify-center bg-gray-100">
    <!-- Container Form Login -->
    <div class="mt-[60px] w-full max-w-sm rounded-lg bg-white p-8 shadow-lg lg:mt-[70px]">
        <!-- Logo Brand -->
        <div class="mb-8 flex flex-col items-center justify-center gap-3">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/laravel.svg') }}" alt="Brand Logo" class="h-16 w-16">
                <h2 class="text-2xl font-semibold">Olsop</h2>
            </div>
            <h2 class="text-xl font-semibold text-slate-600">Login disini!</h2>
        </div>

        <!-- Form Login -->
        <form wire:submit="login">
            <!-- Email Input -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input wire:model="form.email" type="email" id="email"
                    class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Email">
                @error('form.email')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password Input -->
            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input wire:model="form.password" type="password" id="password"
                    class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Password">
                @error('form.password')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <!-- Submit Button -->
            <button type="submit"
                class="w-full rounded-md bg-blue-500 py-2 font-semibold text-white hover:bg-blue-600 focus:outline-none">
                Login
            </button>

            <!-- Forgot Password Link -->
            <div class="mt-4 text-center">
                <span class="text-sm">Belum punya akun?<a href="{{ route('front.register') }}"
                        class="ml-1 text-sm text-blue-500 hover:underline" wire:navigate>Daftar
                        disini</a></span>
            </div>
        </form>
    </div>
</div>
