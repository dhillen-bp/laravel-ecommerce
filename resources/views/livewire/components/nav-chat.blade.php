<div class="relative inline-flex">
    <a href="{{ route('chat') }}" wire:navigate class="btn btn-circle btn-text size-10" aria-label="Cart">
        <div class="indicator">
            <span class="badge indicator-item badge-warning size-4 rounded-full p-0">
                <span class="text-sm">{{ $countUnseenMessage }}</span>
            </span>
            <span class="icon-[tabler--message] size-[1.375rem] text-base-content"></span>
        </div>
    </a>
</div>
