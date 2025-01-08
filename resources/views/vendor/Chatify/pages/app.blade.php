@extends('components.layouts.app')
@section('content')
    <title>Chat</title>
    @include('Chatify::layouts.headLinks')
    <div class="messenger mt-20">
        {{-- ----------------------Users/Groups lists side---------------------- --}}
        <div class="messenger-listView {{ !!$id ? 'conversation-active' : '' }}">
            {{-- Header and search bar --}}
            <div class="m-header">
                <nav>
                    <a href="#"><i class="fas fa-inbox"></i> <span class="messenger-headTitle">MESSAGES</span> </a>
                    {{-- header buttons --}}
                    <nav class="m-header-right">
                        <a href="#"><i class="fas fa-cog settings-btn"></i></a>
                        <a href="#" class="listView-x"><i class="fas fa-times"></i></a>
                    </nav>
                </nav>
                {{-- Search input --}}
                <input type="text" class="messenger-search" placeholder="Search" />
                {{-- Tabs --}}
                {{-- <div class="messenger-listView-tabs">
                <a href="#" class="active-tab" data-view="users">
                    <span class="far fa-user"></span> Contacts</a>
            </div> --}}
            </div>
            {{-- tabs and lists --}}
            <div class="m-body contacts-container">
                {{-- Lists [Users/Group] --}}
                {{-- ---------------- [ User Tab ] ---------------- --}}
                <div class="show messenger-tab users-tab app-scroll" data-view="users">
                    {{-- Favorites --}}
                    <div class="favorites-section">
                        <p class="messenger-title"><span>Favorites</span></p>
                        <div class="messenger-favorites app-scroll-hidden"></div>
                    </div>
                    {{-- Saved Messages --}}
                    <p class="messenger-title"><span>Your Space</span></p>
                    {!! view('Chatify::layouts.listItem', ['get' => 'saved']) !!}
                    {{-- Contact --}}
                    <p class="messenger-title"><span>All Messages</span></p>
                    <div class="listOfContacts" style="width: 100%;height: calc(100% - 272px);position: relative;"></div>
                </div>
                {{-- ---------------- [ Search Tab ] ---------------- --}}
                <div class="messenger-tab search-tab app-scroll" data-view="search">
                    {{-- items --}}
                    <p class="messenger-title"><span>Search</span></p>
                    <div class="search-records">
                        <p class="message-hint center-el"><span>Type to search..</span></p>
                    </div>
                </div>
            </div>
        </div>

        {{-- ----------------------Messaging side---------------------- --}}
        <div class="messenger-messagingView">
            {{-- header title [conversation name] amd buttons --}}
            <div class="m-header m-header-messaging">
                <nav class="chatify-d-flex chatify-justify-content-between chatify-align-items-center">
                    {{-- header back button, avatar and user name --}}
                    <div class="chatify-d-flex chatify-justify-content-between chatify-align-items-center">
                        <a href="#" class="show-listView"><i class="fas fa-arrow-left"></i></a>
                        <div class="av-s header-avatar avatar"
                            style="margin: 0px 10px; margin-top: -5px; margin-bottom: -5px;">
                        </div>
                        <a href="#" class="user-name">{{ config('chatify.name') }}</a>
                    </div>
                    {{-- header buttons --}}
                    <nav class="m-header-right">
                        <a href="#" class="add-to-favorite"><i class="fas fa-star"></i></a>
                        <a href="/"><i class="fas fa-home"></i></a>
                        <a href="#" class="show-infoSide"><i class="fas fa-info-circle"></i></a>
                    </nav>
                </nav>
                {{-- Internet connection --}}
                <div class="internet-connection">
                    <span class="ic-connected">Connected</span>
                    <span class="ic-connecting">Connecting...</span>
                    <span class="ic-noInternet">No internet access</span>
                </div>
            </div>

            {{-- Messaging area --}}
            <div class="m-body messages-container app-scroll">
                {{-- CUSTOM CHAT --}}
                @isset($context_type)
                    @if ($context_type === 'product')
                        <div class="mx-6 mb-3 flex items-center justify-center space-x-6 rounded bg-[#fff] py-3 shadow-sm">
                            <img src="{{ $context->image != null ? formatImageUrl($context->image) : asset('images/laravel.svg') }}"
                                class="h-16 w-16 rounded-lg object-cover md:h-20 md:w-20">
                            <div class="space-y-2">
                                <h4>{{ $context->name }}</h4>
                                <p class="text-sm text-slate-600">{{ Str::limit($context->description, 100) . '...' }}</p>
                                <a href="{{ route('front.products.show', $context->slug) }}" class="btn btn-primary btn-sm"
                                    wire:navigate>Lihat Produk</a>
                            </div>
                        </div>
                    @elseif ($context_type === 'order')
                        <div class="mx-6 mb-3 flex items-center justify-center space-x-6 rounded bg-[#fff] py-3 shadow-sm">
                            <div class="space-y-2">
                                <h4 class="text-wrap">Order ID: {{ $context->id }}</h4>
                                <p>Status:
                                    <span
                                        class="{{ orderStatusClass($context->status) }} mr-2 rounded-full px-2 py-1 font-medium">{{ orderStatus($context->status) }}</span>
                                </p>
                                <p>Tracking Number:
                                    <span>{{ $context->tracking_number ?? '-' }}</span>
                                </p>
                                <a href="{{ route('front.order_detail', $context->id) }}" class="btn btn-primary btn-sm"
                                    wire:navigate>Lihat Pesanan</a>
                            </div>
                        </div>
                    @else
                        <div></div>
                    @endif
                @endisset

                <div class="messages">
                    <p class="message-hint center-el"><span>Please select a chat to start messaging</span></p>
                </div>

                {{-- Typing indicator --}}
                <div class="typing-indicator">
                    <div class="message-card typing">
                        <div class="message">
                            <span class="typing-dots">
                                <span class="dot dot-1"></span>
                                <span class="dot dot-2"></span>
                                <span class="dot dot-3"></span>
                            </span>
                        </div>
                    </div>
                </div>

            </div>
            {{-- Send Message Form --}}
            @include('Chatify::layouts.sendForm')
        </div>
        {{-- ---------------------- Info side ---------------------- --}}
        <div class="messenger-infoView app-scroll">
            {{-- nav actions --}}
            <nav>
                <p>User Details</p>
                <a href="#"><i class="fas fa-times"></i></a>
            </nav>
            {!! view('Chatify::layouts.info')->render() !!}
        </div>
    </div>

    @include('Chatify::layouts.modals')
    @include('Chatify::layouts.footerLinks')

@endsection
