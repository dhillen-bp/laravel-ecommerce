<div class="mx-auto max-w-3xl rounded-lg bg-white p-6 shadow-md">
    <h2 class="mb-4 mt-14 text-2xl font-semibold text-gray-800 md:mt-20">My Profile</h2>

    <div class="space-y-4">
        <form wire:submit.prevent="updateProfile">
            <div>
                <label for="name" class="font-medium text-gray-600">Name</label>
                <input wire:model="name" id="name" type="text"
                    class="mt-2 w-full rounded-md border border-gray-300 p-2" wire:model="name" required />
            </div>

            <div>
                <label for="email" class="font-medium text-gray-600">Email</label>
                <input wire:model="email" id="email" type="email"
                    class="mt-2 w-full rounded-md border border-gray-300 p-2" wire:model="email" required />
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
                </div>

                <div>
                    <label for="new_password" class="font-medium text-gray-600">New Password</label>
                    <input wire:model="new_password" id="new_password" type="password"
                        class="mt-2 w-full rounded-md border border-gray-300 p-2" wire:model="new_password" required />
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
