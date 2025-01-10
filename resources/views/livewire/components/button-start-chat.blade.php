<div class="mt-4 flex items-center justify-between">
    <button class="btn btn-warning" wire:click="$set('showModal', true)">
        <span class="icon-[tabler--message-plus] h-5"></span>
        <span class="hidden text-sm lg:block">Mulai Chat dengan Admin</span>
    </button>

    <!-- Modal -->
    @if ($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-800 bg-opacity-50">
            <div class="w-full max-w-md rounded bg-white p-6 shadow-lg">
                <h2 class="mb-4 text-lg font-bold">
                    Untuk melanjutkan Chat, Pilih Admin yang akan dikirimi pesan.
                </h2>
                <ul>
                    @foreach ($admins as $admin)
                        <li class="mb-2">
                            <button
                                class="flex w-full items-center justify-between rounded bg-gray-100 p-2 text-left hover:bg-gray-200"
                                wire:click="selectAdmin({{ $admin->id }})">
                                <span>{{ $admin->name }}</span>

                                <span class="ml-2 inline-block h-3 w-3 rounded-full"
                                    style="background-color: {{ $admin->active_status ? '#22c55e' : '#9ca3af' }}"
                                    title="{{ $admin->active_status ? 'Online' : 'Offline' }}">
                                </span>
                            </button>
                        </li>
                    @endforeach
                </ul>
                <button class="mt-4 rounded bg-red-500 px-4 py-2 text-white" wire:click="$set('showModal', false)">
                    Tutup
                </button>
            </div>
        </div>
    @endif
</div>
