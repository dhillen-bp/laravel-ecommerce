<div class="container mx-auto min-h-screen p-4">
    <h1 class="mb-6 mt-20 text-center text-3xl font-bold">Notifikasi</h1>

    <div class="flex flex-col gap-4">
        @foreach ($notifications as $notification)
            <div
                class="{{ is_null($notification->read_at) ? 'border-warning' : '' }} flex items-center justify-between rounded-lg border p-4 shadow">
                <div class="flex space-x-8 md:space-x-6">

                    <div class="flex flex-col gap-2">
                        <h2 class="text-lg font-semibold">{{ $notification->data['title'] ?? 'No Title' }}</h2>
                        <p class="text-sm text-gray-600">
                            {!! $notification->data['body'] ?? 'No Message' !!}
                        </p>
                        <span class="text-xs text-gray-500">
                            {{ $notification->created_at->diffForHumans() }}
                        </span>
                    </div>
                </div>

                <div class="flex h-full flex-col justify-between gap-y-8">
                    @if (is_null($notification->read_at))
                        <button wire:click="markAsRead('{{ $notification->id }}')" type="button"
                            class="btn btn-success btn-sm rounded-full">Baca</button>
                    @else
                        <span class="text-sm font-semibold text-green-600">Dibaca</span>
                    @endif
                    <button wire:click="delete('{{ $notification->id }}')" type="button"
                        class="btn btn-error btn-sm rounded-full">Hapus</button>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-6 space-y-2 rounded-lg border p-4 shadow">
        <div class="flex justify-between">
            <div>
                <h2 class="text-lg font-semibold">Total Notifikasi Belum Dibaca</h2>
            </div>
            <div class="text-lg font-bold">
                <span class="badge badge-warning rounded-full"> {{ $unreadCount }}</span>
            </div>
        </div>
        <div class="flex justify-between">
            <div>
                <h2 class="text-lg font-semibold">Total Notifikasi</h2>
            </div>
            <div class="text-lg font-bold">
                <span class="badge badge-primary rounded-full">{{ count($notifications) }}</span>
            </div>
        </div>
    </div>

    <div class="mt-6 text-center">
        <button wire:click="markAllAsRead" class="btn btn-primary w-full rounded-full">
            Tandai Semua Sudah Dibaca
        </button>
    </div>

</div>
