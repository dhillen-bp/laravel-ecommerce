<div class="dropdown relative inline-flex [--auto-close:inside] [--offset:8] [--placement:bottom-end]">
    <button id="dropdown-scrollable" type="button"
        class="dropdown-toggle btn btn-circle btn-text size-10 dropdown-open:bg-base-content/10" aria-haspopup="menu"
        aria-expanded="false" aria-label="Dropdown">
        <div class="indicator">
            <span class="badge indicator-item badge-warning size-4 rounded-full p-0">
                <span class="text-sm">{{ $unread_count }}</span>
            </span>
            <span class="icon-[tabler--bell-ringing] size-[1.375rem] text-base-content"></span>
        </div>
    </button>
    <div class="dropdown-menu hidden dropdown-open:opacity-100" role="menu" aria-orientation="vertical"
        aria-labelledby="dropdown-scrollable">
        <div class="dropdown-header justify-center">
            <h6 class="text-base text-base-content/90">Notifications</h6>
        </div>
        <div
            class="horizontal-scroll vertical-scrollbar rounded-scrollbar max-h-56 w-full max-w-[500px] overflow-auto text-base-content/80 max-sm:max-w-80">
            @forelse ($notifications as $notification)
                <div class="dropdown-item flex w-full items-center">
                    <div class="flex w-full gap-2 border-b border-gray-200 px-2 py-2">
                        <div class="flex w-full justify-between gap-y-2">
                            <div class="flex flex-col">
                                <h6 class="truncate text-sm font-semibold">
                                    {{ $notification->data['title'] ?? 'No Title' }}
                                </h6>
                                <small
                                    class="text-sm text-gray-500">{{ $notification->created_at->diffForHumans() }}</small>
                                <div class="text-sm text-base-content">
                                    {!! $notification->data['body'] ?? 'No Message' !!}
                                </div>
                            </div>
                            <div class="flex flex-col items-end justify-between gap-4">
                                @if (is_null($notification->read_at))
                                    <button wire:click="markAsRead('{{ $notification->id }}')" type="button"
                                        class="btn btn-success btn-xs" onclick="event.stopPropagation()">Mark as
                                        Read</button>
                                @else
                                    <span class="text-xs text-green-500">Read</span>
                                @endif
                                <button wire:click="delete('{{ $notification->id }}')" type="button"
                                    class="btn btn-error btn-xs" onclick="event.stopPropagation()">Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-4 text-center text-sm text-gray-500">No Notifications</div>
            @endforelse
        </div>

        <div class="dropdown-footer justify-center p-4">
            <button wire:click="markAllAsRead" class="btn btn-primary btn-sm w-full rounded-full"
                onclick="event.stopPropagation()">Mark All as Read</button>
        </div>

        <a href="{{ route('front.notification') }}" class="dropdown-footer justify-center gap-1">
            <span class="icon-[tabler--eye] size-4"></span> View all
        </a>
    </div>
</div>
