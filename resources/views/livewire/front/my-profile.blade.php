<div class="mx-auto max-w-3xl rounded-lg bg-white p-6 shadow-md">
    <h2 class="mb-4 mt-14 text-2xl font-semibold text-gray-800 md:mt-20">My Profile</h2>

    <div class="space-y-4">
        <form wire:submit="updateProfile">
            <div>
                <label for="name" class="font-medium text-gray-600">Name</label>
                <input wire:model="name" id="name" type="text"
                    class="mt-2 w-full rounded-md border border-gray-300 p-2" wire:model="name" required />
            </div>

            <div class="mt-6">
                <label for="email" class="flex items-center gap-2 font-medium text-gray-600">
                    <span>Email</span>
                    @if ($email_verified_at)
                        <span class="badge badge-success badge-sm rounded-full">Verified</span>
                    @else
                        <span class="badge badge-error badge-sm rounded-full">Unverified</span>
                    @endif
                </label>
                <input wire:model="email" id="email" type="email"
                    class="mt-2 w-full rounded-md border border-gray-300 p-2" wire:model="email" required />
            </div>

            <div class="mt-6">
                <label for="province_id" class="font-medium text-gray-600">Pilih Provinsi</label>
                <select wire:model.live="province_id" id="province_id"
                    class="mt-2 w-full rounded-md border border-gray-300 p-2" required>
                    <option value="">Pilih Provinsi</option>
                    @foreach ($provinces as $province)
                        <option value="{{ $province->id }}">{{ $province->name }}</option>
                    @endforeach
                </select>
                @error('province_id')
                    <span class="text-sm text-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="mt-6">
                <label for="city_id" class="font-medium text-gray-600">Pilih Kota</label>
                <select wire:model="city_id" id="city_id" class="mt-2 w-full rounded-md border border-gray-300 p-2"
                    required>
                    <option value="">Pilih Kota</option>
                    @foreach ($cities as $city)
                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                    @endforeach
                </select>
                @error('city_id')
                    <span class="text-sm text-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="mt-6">
                <label for="address" class="font-medium text-gray-600">Alamat</label>
                <textarea wire:model="address" id="address" class="mt-2 w-full rounded-md border border-gray-300 p-2" rows="3"
                    required></textarea>
                @error('address')
                    <span class="text-sm text-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="mt-6">
                <label for="postal_code" class="font-medium text-gray-600">Kode Pos</label>
                <input wire:model="postal_code" id="postal_code" type="number"
                    class="mt-2 w-full rounded-md border border-gray-300 p-2" required />
                @error('postal_code')
                    <span class="text-sm text-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="mt-6 flex">
                <button type="submit" class="btn btn-primary w-full">
                    Perbarui Profil
                </button>
            </div>
        </form>

        <form wire:submit.prevent="updatePassword">
            <div class="mt-6 space-y-3 border-t pt-4">
                <h3 class="mb-4 text-lg font-semibold text-gray-800">Change Password</h3>

                <div>
                    <label for="current_password" class="font-medium text-gray-600">Current Password</label>
                    <input wire:model="current_password" id="current_password" type="password"
                        class="mt-2 w-full rounded-md border border-gray-300 p-2" wire:model="current_password"
                        required />
                    @error('current_password')
                        <span class="text-sm text-error">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="new_password" class="font-medium text-gray-600">New Password</label>
                    <input wire:model="new_password" id="new_password" type="password"
                        class="mt-2 w-full rounded-md border border-gray-300 p-2" wire:model="new_password" required />
                    @error('new_password')
                        <span class="text-sm text-error">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="confirm_password" class="font-medium text-gray-600">Confirm New Password</label>
                    <input id="confirm_password" type="password"
                        class="mt-2 w-full rounded-md border border-gray-300 p-2" wire:model="confirm_password"
                        required />
                </div>
            </div>

            <div class="mt-6 flex">
                <button type="submit" class="btn btn-primary w-full">
                    Ubah Password
                </button>
            </div>
        </form>
    </div>

</div>
