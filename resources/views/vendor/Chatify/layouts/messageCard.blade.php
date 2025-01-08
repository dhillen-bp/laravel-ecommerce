<?php
$seenIcon = !!$seen ? 'check-double' : 'check';
$timeAndSeen =
    "<span data-time='$created_at' class='message-time'>
        " .
    ($isSender ? "<span class='fas fa-$seenIcon' seen'></span>" : '') .
    " <span class='time'>$timeAgo</span>
    </span>";
?>

<div class="message-card @if ($isSender) mc-sender @endif" data-id="{{ $id }}">
    {{-- Delete Message Button --}}
    @if ($isSender)
        <div class="actions">
            <i class="fas fa-trash delete-btn" data-id="{{ $id }}"></i>
        </div>
    @endif
    {{-- Card --}}
    <div class="message-card-content">
        @if (@$attachment->type != 'image' || $message)
            <div class="message">

                {{-- CUSTOM CHAT --}}
                @if ($product)
                    <div class="mb-2 flex items-center justify-center space-x-2 rounded-lg bg-[#e599ff] p-2 text-black shadow-sm"
                        style="margin-top: 8px">
                        <img src="{{ $product->image != null ? formatImageUrl($product->image) : asset('images/laravel.svg') }}"
                            class="w-1h-16 h-16 rounded-lg bg-white object-cover p-2 md:h-20 md:w-20">
                        <div class="space-y-2">
                            <h4>{{ $product->name }}</h4>
                            <p class="text-sm text-slate-600">{{ Str::limit($product->description, 50) . '...' }}</p>
                            <a href="{{ route('front.products.show', $product->slug) }}" class="btn btn-primary btn-sm"
                                wire:navigate>Lihat Produk</a>
                        </div>
                    </div>
                @elseif($order)
                    <div class="mb-2 flex items-center justify-center space-x-2 rounded-lg bg-[#e599ff] p-2 text-black shadow-sm"
                        style="margin-top: 8px">
                        <div class="space-y-2">
                            <h4 class="text-wrap">Order ID: {{ $order->id }}</h4>
                            <p>Status:
                                <span
                                    class="{{ orderStatusClass($order->status) }} mr-2 rounded-full px-2 py-1 font-medium">{{ orderStatus($order->status) }}</span>
                            </p>
                            <p>Tracking Number:
                                <span>{{ $order->tracking_number ?? '-' }}</span>
                            </p>
                            <a href="{{ route('front.order_detail', $order->id) }}" class="btn btn-primary btn-sm"
                                wire:navigate>Lihat Pesanan</a>
                        </div>
                    </div>
                @else
                    <div></div>
                @endif

                {!! $message == null && $attachment != null && @$attachment->type != 'file'
                    ? $attachment->title
                    : nl2br($message) !!}
                {!! $timeAndSeen !!}
                {{-- If attachment is a file --}}
                @if (@$attachment->type == 'file')
                    <a href="{{ route(config('chatify.attachments.download_route_name'), ['fileName' => $attachment->file]) }}"
                        class="file-download">
                        <span class="fas fa-file"></span> {{ $attachment->title }}</a>
                @endif
            </div>
        @endif
        @if (@$attachment->type == 'image')
            <div class="image-wrapper" style="text-align: {{ $isSender ? 'end' : 'start' }}">
                <div class="image-file chat-image"
                    style="background-image: url('{{ Chatify::getAttachmentUrl($attachment->file) }}')">
                    <div>{{ $attachment->title }}</div>
                </div>
                <div style="margin-bottom:5px">
                    {!! $timeAndSeen !!}
                </div>
            </div>
        @endif
    </div>
</div>
